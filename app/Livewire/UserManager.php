<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Division;
use App\Models\Branch;
use App\Models\OfficeRole;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserManager extends Component
{
    public $name, $email, $password, $role_id, $division_id, $branch_id, $office_role_id;
    public $users;
    public $editingId;
    public $roles, $divisions, $branches, $officeRoles;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
        'role_id' => 'required|exists:roles,id',
        'division_id' => 'nullable|exists:divisions,id',
        'branch_id' => 'nullable|exists:branches,id',
        'office_role_id' => 'nullable|exists:office_roles,id',
    ];

    public function mount()
    {
        $this->users = User::all();
        $this->roles = Role::all();
        $this->divisions = Division::all();
        $this->branches = Branch::all();
        $this->officeRoles = OfficeRole::all();
    }

    public function create()
    {
        if (Gate::allows('manage-hr')) {
            $this->validate();
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role_id' => $this->role_id,
                'division_id' => $this->division_id,
                'branch_id' => $this->branch_id,
                'office_role_id' => $this->office_role_id,
            ]);
            $this->resetInput();
            $this->users = User::all();
            session()->flash('message', 'User created successfully.');
        }
    }

    public function edit($id)
    {
        if (Gate::allows('manage-hr')) {
            $this->editingId = $id;
            $user = User::find($id);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = '';
            $this->role_id = $user->role_id;
            $this->division_id = $user->division_id;
            $this->branch_id = $user->branch_id;
            $this->office_role_id = $user->office_role_id;
        }
    }

    public function update()
    {
        if (Gate::allows('manage-hr')) {
            $this->validate(array_merge($this->rules, ['email' => 'required|email|max:255|unique:users,email,' . $this->editingId]));
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'role_id' => $this->role_id,
                'division_id' => $this->division_id,
                'branch_id' => $this->branch_id,
                'office_role_id' => $this->office_role_id,
            ];
            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }
            User::find($this->editingId)->update($data);
            $this->resetInput();
            $this->users = User::all();
            session()->flash('message', 'User updated successfully.');
        }
    }

    public function delete($id)
    {
        if (Gate::allows('manage-hr')) {
            User::find($id)->delete();
            $this->users = User::all();
            session()->flash('message', 'User deleted successfully.');
        }
    }

    private function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role_id = '';
        $this->division_id = '';
        $this->branch_id = '';
        $this->office_role_id = '';
        $this->editingId = null;
    }

    public function render()
    {
        return view('livewire.user-manager', [
            'roles' => $this->roles,
            'divisions' => $this->divisions,
            'branches' => $this->branches,
            'officeRoles' => $this->officeRoles,
        ]);
    }
}
