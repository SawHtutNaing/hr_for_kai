<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use App\Models\Payroll;
use Illuminate\Support\Facades\Gate;
use App\Notifications\LeaveRequestStatus;

class HrDashboard extends Component
{
    public $employeeCount;
    public $pendingLeaveRequests;
    public $recentAttendances;
    public $recentPayrolls;

    public function mount()
    {
        if (Gate::allows('manage-hr')) {
            $this->employeeCount = User::whereHas('role', fn($query) => $query->where('name', 'Employee'))->count();
            $this->pendingLeaveRequests = LeaveRequest::where('status', 'pending')->latest()->take(5)->get();
            $this->recentAttendances = Attendance::latest()->take(5)->get();
            $this->recentPayrolls = Payroll::latest()->take(5)->get();
        }
    }

    public function approve($id)
    {
        if (Gate::allows('manage-hr')) {
            $leave = LeaveRequest::find($id);
            $leave->update(['status' => 'approved', 'approved_by' => auth()->id()]);
            $leave->user->notify(new LeaveRequestStatus($leave));
            $this->pendingLeaveRequests = LeaveRequest::where('status', 'pending')->latest()->take(5)->get();
            session()->flash('message', 'Leave request approved and notification sent.');
        }
    }

    public function reject($id)
    {
        if (Gate::allows('manage-hr')) {
            $leave = LeaveRequest::find($id);
            $leave->update(['status' => 'rejected', 'approved_by' => auth()->id()]);
            $leave->user->notify(new LeaveRequestStatus($leave));
            $this->pendingLeaveRequests = LeaveRequest::where('status', 'pending')->latest()->take(5)->get();
            session()->flash('message', 'Leave request rejected and notification sent.');
        }
    }

    public function render()
    {
        return view('livewire.hr-dashboard');
    }
}
