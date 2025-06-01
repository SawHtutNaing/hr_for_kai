<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Gate;
use League\Csv\Writer;

class LeaveRequestManager extends Component
{
    use WithPagination;

    public $start_date, $end_date, $reason;

    protected $rules = [
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|max:1000',
    ];

    public function create()
    {
        if (Gate::allows('manage-employee')) {
            $this->validate();
            LeaveRequest::create([
                'user_id' => auth()->id(),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'reason' => $this->reason,
            ]);
            $this->resetInput();
            session()->flash('message', 'Leave request submitted.');
        }
    }

    public function approve($id)
    {
        if (Gate::allows('manage-hr')) {
            $leave = LeaveRequest::findOrFail($id);
            $leave->update(['status' => 'approved', 'approved_by' => auth()->id()]);
            session()->flash('message', 'Leave request approved.');
        }
    }

    public function reject($id)
    {
        if (Gate::allows('manage-hr')) {
            $leave = LeaveRequest::findOrFail($id);
            $leave->update(['status' => 'rejected', 'approved_by' => auth()->id()]);
            session()->flash('message', 'Leave request rejected.');
        }
    }

    public function prepareExport()
    {
        if (!Gate::allows('manage-hr')) {
            abort(403, 'Unauthorized');
        }

        // Fetch leave requests for HR users
        $data = LeaveRequest::with('user', 'approvedBy')->get();

        // Check if data is empty
        if ($data->isEmpty()) {
            $this->dispatch('exportFailed', message: 'No leave requests available for export.');
            return;
        }

        // Create CSV
        $csv = Writer::createFromString();
        $csv->setDelimiter(',');
        $csv->setOutputBOM(Writer::BOM_UTF8); // UTF-8 BOM for Excel compatibility

        // Write headers and data
        $csv->insertOne(['Employee', 'Start Date', 'End Date', 'Reason', 'Status', 'Approved By']);
        foreach ($data as $record) {
            $csv->insertOne([
                $record->user->name,
                $record->start_date,
                $record->end_date,
                $record->reason,
                $record->status,
                optional($record->approvedBy)->name ?? 'N/A',
            ]);
        }

        // Generate filename
        $filename = 'leave_requests_' . now()->format('Ymd_His') . '.csv';

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

    private function resetInput()
    {
        $this->start_date = '';
        $this->end_date = '';
        $this->reason = '';
    }

    public function render()
    {
        $user = auth()->user();
        $leaveRequests = $user->role->name === 'HR'
            ? LeaveRequest::with('user', 'approvedBy')->paginate(10)
            : $user->leaveRequests()->paginate(10);

        return view('livewire.leave-request-manager', [
            'leaveRequests' => $leaveRequests,
        ]);
    }
}
