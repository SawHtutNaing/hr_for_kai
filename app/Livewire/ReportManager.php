<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use League\Csv\Writer;

class ReportManager extends Component
{
    use WithPagination;

    public $reportType = 'attendance';
    public $startDate, $endDate, $user_id;
    public $users;

    protected $rules = [
        'startDate' => 'nullable|date',
        'endDate' => 'nullable|date|after_or_equal:startDate',
        'user_id' => 'nullable|exists:users,id',
        'reportType' => 'required|in:attendance,payroll',
    ];

    public function mount()
    {
        $this->users = User::whereHas('role', fn($query) => $query->where('name', 'Employee'))->get();
    }

    public function generateReport()
    {
        if (!Gate::allows('manage-hr')) {
            abort(403, 'Unauthorized');
        }
        $this->validate();
        $this->resetPage();
        session()->flash('message', 'Report generated successfully.');
    }

    public function prepareExport()
    {
        if (!Gate::allows('manage-hr')) {
            abort(403, 'Unauthorized');
        }

        // Validate required fields for export
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'reportType' => 'required|in:attendance,payroll',
        ]);

        // Build the query
        $query = $this->reportType === 'attendance' ? Attendance::query() : Payroll::query();

        if ($this->user_id) {
            $query->where('user_id', $this->user_id);
        }

        $query->whereBetween($this->reportType === 'attendance' ? 'date' : 'pay_date', [$this->startDate, $this->endDate]);
        $data = $query->with('user')->get();

        // Check if data is empty
        if ($data->isEmpty()) {
            $this->dispatch('exportFailed', message: 'No data available for export.');
            return;
        }

        // Create CSV
        $csv = Writer::createFromString();
        $csv->setDelimiter(',');
        $csv->setOutputBOM(Writer::BOM_UTF8); // UTF-8 BOM for Excel compatibility

        // Write headers and data
        if ($this->reportType === 'attendance') {
            $csv->insertOne(['Employee', 'Date', 'Check In', 'Check Out', 'Hours Worked']);
            foreach ($data as $record) {
                $csv->insertOne([
                    $record->user->name,
                    $record->date,
                    $record->check_in,
                    $record->check_out ?? 'N/A',
                    $record->hours_worked ?? 'N/A',
                ]);
            }
        } else {
            $csv->insertOne(['Employee', 'Pay Date', 'Amount', 'Details']);
            foreach ($data as $record) {
                $csv->insertOne([
                    $record->user->name,
                    $record->pay_date,
                    number_format($record->amount, 2),
                    $record->details ?? 'N/A',
                ]);
            }
        }

        // Generate filename
        $filename = $this->reportType . '_report_' . now()->format('Ymd_His') . '.csv';

        // Return downloadable response
        return response()->streamDownload(
            fn() => print($csv->toString()),
            $filename,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]
        );
    }

    public function render()
    {
        if (!Gate::allows('manage-hr')) {
            abort(403, 'Unauthorized');
        }

        $query = $this->reportType === 'attendance' ? Attendance::query() : Payroll::query();

        if ($this->user_id) {
            $query->where('user_id', $this->user_id);
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween($this->reportType === 'attendance' ? 'date' : 'pay_date', [$this->startDate, $this->endDate]);
        }

        $reportData = $query->with('user')->paginate(10);

        return view('livewire.report-manager', [
            'users' => $this->users,
            'reportData' => $reportData,
        ]);
    }
}
