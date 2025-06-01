<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use League\Csv\Writer;

class ReportExportController extends Controller
{
    public function exportCsv(Request $request)
    {
        if (!Gate::allows('manage-hr')) {
            abort(403, 'Unauthorized');
        }

        $params = Session::get('report_export', []);
        $reportType = $params['reportType'] ?? 'attendance';
        $user_id = $params['user_id'] ?? null;
        $startDate = $params['startDate'] ?? null;
        $endDate = $params['endDate'] ?? null;

        Session::forget('report_export');

        if (!$startDate || !$endDate) {
            return redirect()->route('reports')->with('message', 'Start date and end date are required for export.');
        }

        $query = $reportType === 'attendance' ? Attendance::query() : Payroll::query();

        if ($user_id) {
            $query->where('user_id', $user_id);
        }

        $query->whereBetween($reportType === 'attendance' ? 'date' : 'pay_date', [$startDate, $endDate]);
        $data = $query->with('user')->get();

        if ($data->isEmpty()) {
            return redirect()->route('reports')->with('message', 'No data available for export.');
        }

        $csv = Writer::createFromString();
        $csv->setDelimiter(',');
        $csv->setOutputBOM(Writer::BOM_UTF8);

        if ($reportType === 'attendance') {
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

        $filename = $reportType . '_report_' . now()->format('Ymd_His') . '.csv';

        return response($csv->toString(), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
