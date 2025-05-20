<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (auth()->user()->role->name === 'HR')
        <form wire:submit.prevent="{{ $editingId ? 'update' : 'create' }}" class="mb-4">
            <div class="flex space-x-4">
                <input wire:model="name" type="text" placeholder="Division Name" class="border rounded px-3 py-2 w-full">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    {{ $editingId ? 'Update' : 'Create' }}
                </button>
            </div>
            @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
        </form>
    @endif

    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left">Name</th>
                @if (auth()->user()->role->name === 'HR')
                    <th class="px-6 py-3 text-right">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($divisions as $division)
                <tr>
                    <td class="px-6 py-4">{{ $division->name }}</td>

                    @if (auth()->user()->role->name === 'HR')
                        <td class="px-6 py-4 text-right">
                            <button wire:click="edit({{ $division->id }})" class="text-blue-500">Edit</button>
                            <button wire:click="delete({{ $division->id }})" class="text-red-500 ml-2">Delete</button>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
