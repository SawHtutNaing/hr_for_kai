<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (auth()->user()->role->name === 'HR')
        <form wire:submit.prevent="{{ $editingId ? 'update' : 'create' }}" class="mb-4">
            <div class="space-y-4">
                <div>
                    <label>Name</label>
                    <input wire:model="name" type="text" placeholder="Name" class="border rounded px-3 py-2 w-full">
                    @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>Email</label>
                    <input wire:model="email" type="email" placeholder="Email" class="border rounded px-3 py-2 w-full">
                    @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>Password</label>
                    <input wire:model="password" type="password" placeholder="Password" class="border rounded px-3 py-2 w-full">
                    @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>Role</label>
                    <select wire:model="role_id" class="border rounded px-3 py-2 w-full">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>Division</label>
                    <select wire:model="division_id" class="border rounded px-3 py-2 w-full">
                        <option value="">Select Division</option>
                        @foreach ($divisions as $division)
                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                        @endforeach
                    </select>
                    @error('division_id') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>Branch</label>
                    <select wire:model="branch_id" class="border rounded px-3 py-2 w-full">
                        <option value="">Select Branch</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('branch_id') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>Office Role</label>
                    <select wire:model="office_role_id" class="border rounded px-3 py-2 w-full">
                        <option value="">Select Office Role</option>
                        @foreach ($officeRoles as $officeRole)
                            <option value="{{ $officeRole->id }}">{{ $officeRole->title }}</option>
                        @endforeach
                    </select>
                    @error('office_role_id') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    {{ $editingId ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>
    @endif

    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left">Name</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Role</th>
                <th class="px-6 py-3 text-left">Division</th>
                <th class="px-6 py-3 text-left">Branch</th>
                <th class="px-6 py-3 text-left">Office Role</th>
                @if (auth()->user()->role->name === 'HR')
                    <th class="px-6 py-3 text-right">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="px-6 py-4">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">{{ $user->role->name }}</td>
                    <td class="px-6 py-4">{{ $user->division->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $user->branch->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $user->officeRole->title ?? 'N/A' }}</td>
                    @if (auth()->user()->role->name === 'HR')
                        <td class="px-6 py-4 text-right">
                            <button wire:click="edit({{ $user->id }})" class="text-blue-500">Edit</button>
                            <button wire:click="delete({{ $user->id }})" class="text-red-500 ml-2">Delete</button>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
