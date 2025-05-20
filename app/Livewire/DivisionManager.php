<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Division;
use Illuminate\Support\Facades\Gate;

class DivisionManager extends Component
{
    public $name;
    public $divisions;
    public $editingId;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->divisions = Division::all();
    }

    public function create()
    {
        if (Gate::allows('manage-hr')) {
            $this->validate();
            Division::create(['name' => $this->name]);
            $this->name = '';
            $this->divisions = Division::all();
            session()->flash('message', 'Division created successfully.');
        }
    }

    public function edit($id)
    {

        if (Gate::allows('manage-hr')) {
            $this->editingId = $id;
            $division = Division::find($id);
            $this->name = $division->name;
        }
    }

    public function update()
    {
        if (Gate::allows('manage-hr')) {
            $this->validate();

            Division::find($this->editingId)->update(['name' => $this->name]);
            $this->resetInput();
            $this->divisions = Division::all();
            session()->flash('message', 'Division updated successfully.');
        }
    }

    public function delete($id)
    {
        if (Gate::allows('manage-hr')) {
            Division::find($id)->delete();
            $this->divisions = Division::all();
            session()->flash('message', 'Division deleted successfully.');
        }
    }

    private function resetInput()
    {
        $this->name = '';
        $this->editingId = null;
    }

    public function render()
    {
        return view('livewire.division-manager');
    }
}
