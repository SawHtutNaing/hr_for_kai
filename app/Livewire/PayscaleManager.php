<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payscale;
use Illuminate\Support\Facades\Gate;

class PayscaleManager extends Component
{
    public $title, $salary;
    public $payscales;
    public $editingId;

    protected $rules = [
        'title' => 'required|string|max:255',
        'salary' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->payscales = Payscale::all();
    }

    public function create()
    {
        if (Gate::allows('manage-hr')) {
            $this->validate();
            Payscale::create([
                'title' => $this->title,
                'salary' => $this->salary,
            ]);
            $this->resetInput();
            $this->payscales = Payscale::all();
            session()->flash('message', 'Payscale created successfully.');
        }
    }

    public function edit($id)
    {
        if (Gate::allows('manage-hr')) {
            $this->editingId = $id;
            $payscale = Payscale::find($id);
            $this->title = $payscale->title;
            $this->salary = $payscale->salary;
        }
    }

    public function update()
    {
        if (Gate::allows('manage-hr')) {
            $this->validate();
            Payscale::find($this->editingId)->update([
                'title' => $this->title,
                'salary' => $this->salary,
            ]);
            $this->resetInput();
            $this->payscales = Payscale::all();
            session()->flash('message', 'Payscale updated successfully.');
        }
    }

    public function delete($id)
    {
        if (Gate::allows('manage-hr')) {
            Payscale::find($id)->delete();
            $this->payscales = Payscale::all();
            session()->flash('message', 'Payscale deleted successfully.');
        }
    }

    private function resetInput()
    {
        $this->title = '';
        $this->salary = '';
        $this->editingId = null;
    }

    public function render()
    {
        return view('livewire.payscale-manager');
    }
}
