<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use Illuminate\Support\Facades\Gate;

class EmployeeDashboard extends Component
{
    public $attendances;
    public $leaveRequests;
    public $payrolls;
    public $canCheckIn;
    public $canCheckOut;
    public $todayStatus;

    public function mount()
    {
        $user = auth()->user();
        $this->attendances = $user->attendances()->latest()->take(5)->get();
        $this->leaveRequests = $user->leaveRequests()->latest()->take(5)->get();
        $this->payrolls = $user->payrolls()->latest()->take(5)->get();

        $today = now()->toDateString();
        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();
        $this->canCheckIn = !$attendance;
        $this->canCheckOut = $attendance && !$attendance->check_out;
        $this->todayStatus = $attendance ? ($attendance->check_out ? 'Checked Out' : 'Checked In') : 'Not Checked In';
    }

    public function checkIn()
    {
        if (Gate::allows('manage-employee')) {
            $today = now()->toDateString();
            if (!Attendance::where('user_id', auth()->id())->where('date', $today)->exists()) {
                Attendance::create([
                    'user_id' => auth()->id(),
                    'check_in' => now(),
                    'date' => $today,
                ]);
                $this->canCheckIn = false;
                $this->canCheckOut = true;
                $this->todayStatus = 'Checked In';
                $this->attendances = auth()->user()->attendances()->latest()->take(5)->get();
                session()->flash('message', 'Checked in successfully.');
            }
        }
    }

    public function checkOut()
    {
        if (Gate::allows('manage-employee')) {
            $today = now()->toDateString();
            $attendance = Attendance::where('user_id', auth()->id())->where('date', $today)->first();
            if ($attendance && !$attendance->check_out) {
                $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                $hoursWorked = now()->diffInMinutes($checkIn) / 60; // Convert minutes to hours
                $attendance->update([
                    'check_out' => now(),
                    'hours_worked' => round($hoursWorked, 2),
                ]);
                $this->canCheckOut = false;
                $this->todayStatus = 'Checked Out';
                $this->attendances = auth()->user()->attendances()->latest()->take(5)->get();
                session()->flash('message', 'Checked out successfully.');
            }
        }
    }

    public function render()
    {
        return view('livewire.employee-dashboard');
    }
}
