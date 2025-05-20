<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OfficeRole;
use App\Models\Payscale;
use Illuminate\Support\Facades\Gate;

class OfficeRoleManager extends Component
{
    public $title, $payscale_id;
    public $officeRoles;
    public $editingId;
    public $payscales;

    protected $rules = [
        'title' => 'required|string|max:255',
        'payscale_id' => 'required|exists:payscales,id',
    ];

    public function mount()
    {
        $this->officeRoles = OfficeRole::all();
        $this->payscales = Payscale::all();
    }

    public function create()
    {
        if (Gate::allows('manage-hr')) {
            $this->validate();
            OfficeRole::create([
                'title' => $this->title,
                'payscale_id' => $this->payscale_id,
            ]);
            $this->resetInput();
            $this->officeRoles = OfficeRole::all();
            session()->flash('message', 'Office Role created successfully.');
        }
    }

    public function edit($id)
    {
        if (Gate::allows('manage-hr')) {
            $this->editingId = $id;
            $officeRole = OfficeRole::find($id);
            $this->title = $officeRole->title;
            $this->payscale_id = $officeRole->payscale_id;
        }
    }

    public function update()
    {
        if (Gate::allows('manage-hr')) {
            $this->validate();
            OfficeRole::find($this->editingId)->update([
                'title' => $this->title,
                'payscale_id' => $this->payscale_id,
            ]);
            $this->resetInput();
            $this->officeRoles = OfficeRole::all();
            session()->flash('message', 'Office Role updated successfully.');
        }
    }

    public function delete($id)
    {
        if (Gate::allows('manage-hr')) {
            OfficeRole::find($id)->delete();
            $this->officeRoles = OfficeRole::all();
            session()->flash('message', 'Office Role deleted successfully.');
        }
    }

    private function resetInput()
    {
        $this->title = '';
        $this->payscale_id = '';
        $this->editingId = null;
    }

    public function render()
    {
        return view('livewire.office-role-manager', ['payscales' => $this->payscales]);
    }
}
