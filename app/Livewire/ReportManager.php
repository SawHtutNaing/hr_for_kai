<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class ReportManager extends Component
{
    use WithPagination;

    public $reportType = 'attendance';
    public $startDate, $endDate, $user_id;
    public $users;
    public $reportData;

    public function mount()
    {
        $this->users = User::whereHas('role', fn($query) => $query->where('name', 'Employee'))->get();
        $this->generateReport();
    }

    public function generateReport()
    {
        if (Gate::allows('manage-hr')) {
            $query = $this->reportType === 'attendance' ? Attendance::query() : Payroll::query();

            if ($this->user_id) {
                $query->where('user_id', $this->user_id);
            }

            if ($this->startDate && $this->endDate) {
                $query->whereBetween('date', [$this->startDate, $this->endDate]);
            }

            $this->reportData = $query->get();
        }
    }

    public function render()
    {
        return view('livewire.report-manager', ['users' => $this->users]);
    }
}
