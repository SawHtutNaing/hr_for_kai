<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Branch;
use Illuminate\Support\Facades\Gate;

class BranchManager extends Component
{
    public $name, $location;
    public $branches;
    public $editingId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        $this->branches = Branch::all();
    }

    public function create()
    {
        if (Gate::allows('manage-hr')) {
            $this->validate();
            Branch::create([
                'name' => $this->name,
                'location' => $this->location,
            ]);
            $this->resetInput();
            $this->branches = Branch::all();
            session()->flash('message', 'Branch created successfully.');
        }
    }

    public function edit($id)
    {
        if (Gate::allows('manage-hr')) {
            $this->editingId = $id;
            $branch = Branch::find($id);
            $this->name = $branch->name;
            $this->location = $branch->location;
        }
    }

    public function update()
    {
        if (Gate::allows('manage-hr')) {
            $this->validate();
            Branch::find($this->editingId)->update([
                'name' => $this->name,
                'location' => $this->location,
            ]);
            $this->resetInput();
            $this->branches = Branch::all();
            session()->flash('message', 'Branch updated successfully.');
        }
    }

    public function delete($id)
    {
        if (Gate::allows('manage-hr')) {
            Branch::find($id)->delete();
            $this->branches = Branch::all();
            session()->flash('message', 'Branch deleted successfully.');
        }
    }

    private function resetInput()
    {
        $this->name = '';
        $this->location = '';
        $this->editingId = null;
    }

    public function render()
    {
        return view('livewire.branch-manager');
    }
}
