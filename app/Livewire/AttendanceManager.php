<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Support\Facades\Gate;

class AttendanceManager extends Component
{
    public $attendances;

    public function mount()
    {
        $user = auth()->user();
        $this->attendances = $user->role->name === 'HR' ? Attendance::all() : $user->attendances;
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
                session()->flash('message', 'Checked in successfully.');
                $this->attendances = auth()->user()->attendances;
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
                $hoursWorked = now()->diffInHours($checkIn);
                $attendance->update([
                    'check_out' => now(),
                    'hours_worked' => $hoursWorked,
                ]);
                session()->flash('message', 'Checked out successfully.');
                $this->attendances = auth()->user()->attendances;
            }
        }
    }

    public function render()
    {
        return view('livewire.attendance-manager');
    }
}
