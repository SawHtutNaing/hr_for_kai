<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use League\Csv\Writer;

class LeaveRequestExportController extends Controller
{
    public function exportCsv(Request $request)
    {
        if (!Gate::allows('manage-hr')) {
            abort(403, 'Unauthorized');
        }

        $data = LeaveRequest::with('user', 'approvedBy')->get();

        if ($data->isEmpty()) {
            return redirect()->back()->with('message', 'No leave requests available for export.');
        }

        $csv = Writer::createFromString();
        $csv->setDelimiter(',');
        $csv->setOutputBOM(Writer::BOM_UTF8);

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

        $filename = 'leave_requests_' . now()->format('Ymd_His') . '.csv';

        return response($csv->toString(), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
