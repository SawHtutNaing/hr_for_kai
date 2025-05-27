<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payroll;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Gate;

class PayrollManager extends Component
{
    use WithPagination;

    public $payrolls;
    public $user_id, $pay_date, $details;
    public $users;

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'pay_date' => 'required|date',
        'details' => 'nullable|string|max:1000',
    ];

    public function mount()
    {
        $this->users = User::whereHas('role', fn($query) => $query->where('name', 'Employee'))->get();
        $user = auth()->user();
        $this->payrolls = $user->role->name === 'HR' ? Payroll::get() : $user->payrolls()->get();
    }

    public function create()
    {
        if (Gate::allows('manage-hr')) {
            $this->validate();
            $user = User::find($this->user_id);
            $payscale = $user->officeRole ? $user->officeRole->payscale : null;
            $hourlyRate = $payscale ? $payscale->salary / 2080 : 0;
            $hoursWorked = Attendance::where('user_id', $this->user_id)
                ->whereMonth('date', \Carbon\Carbon::parse($this->pay_date)->month)
                ->sum('hours_worked');
            $amount = $hourlyRate * $hoursWorked;

            Payroll::create([
                'user_id' => $this->user_id,
                'amount' => $amount,
                'pay_date' => $this->pay_date,
                'details' => $this->details,
            ]);
            $this->resetInput();
            $this->payrolls = Payroll::get();
            session()->flash('message', 'Payroll entry created.');
        }
    }

    private function resetInput()
    {
        $this->user_id = '';
        $this->pay_date = '';
        $this->details = '';
    }

    public function render()
    {
        return view('livewire.payroll-manager', ['users' => $this->users]);
    }
}
