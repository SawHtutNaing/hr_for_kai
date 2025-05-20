<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Gate;

class LeaveRequestManager extends Component
{
    public $start_date, $end_date, $reason;
    public $leaveRequests;

    protected $rules = [
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|max:1000',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->leaveRequests = $user->role->name === 'HR' ? LeaveRequest::all() : $user->leaveRequests;
    }

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
            $this->leaveRequests = auth()->user()->leaveRequests;
            session()->flash('message', 'Leave request submitted.');
        }
    }

    public function approve($id)
    {
        if (Gate::allows('manage-hr')) {
            $leave = LeaveRequest::find($id);
            $leave->update(['status' => 'approved', 'approved_by' => auth()->id()]);
            $this->leaveRequests = LeaveRequest::all();
            session()->flash('message', 'Leave request approved.');
        }
    }

    public function reject($id)
    {
        if (Gate::allows('manage-hr')) {
            $leave = LeaveRequest::find($id);
            $leave->update(['status' => 'rejected', 'approved_by' => auth()->id()]);
            $this->leaveRequests = LeaveRequest::all();
            session()->flash('message', 'Leave request rejected.');
        }
    }

    private function resetInput()
    {
        $this->start_date = '';
        $this->end_date = '';
        $this->reason = '';
    }

    public function render()
    {
        return view('livewire.leave-request-manager');
    }
}
