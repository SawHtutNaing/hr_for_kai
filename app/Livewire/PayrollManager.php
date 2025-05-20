<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class PayrollManager extends Component
{
    public $payrolls;
    public $amount, $pay_date, $details, $user_id;

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:0',
        'pay_date' => 'required|date',
        'details' => 'nullable|string|max:1000',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->payrolls = $user->role->name === 'HR' ? Payroll::all() : $user->payrolls;
    }

    public function create()
    {
        if (Gate::allows('manage-hr')) {
            $this->validate();
            Payroll::create([
                'user_id' => $this->user_id,
                'amount' => $this->amount,
                'pay_date' => $this->pay_date,
                'details' => $this->details,
            ]);
            $this->resetInput();
            $this->payrolls = Payroll::all();
            session()->flash('message', 'Payroll entry created.');
        }
    }

    private function resetInput()
    {
        $this->user_id = '';
        $this->amount = '';
        $this->pay_date = '';
        $this->details = '';
    }

    public function render()
    {
        $users = User::all();
        return view('livewire.payroll-manager', compact('users'));
    }
}
