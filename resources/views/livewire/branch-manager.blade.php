<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (auth()->user()->role->name === 'HR')
        <div class="mb-4">
            <input wire:model.debounce.500ms="search" type="text" placeholder="Search branches..." class="border rounded px-3 py-2 w-full">
        </div>
        <form wire:submit.prevent="{{ $editingId ? 'update' : 'create' }}" class="mb-4">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Branch Name</label>
                    <input wire:model="name" type="text" placeholder="Branch Name" class="border rounded px-3 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Location</label>
                    <input wire:model="location" type="text" placeholder="Location" class="border rounded px-3 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500">
                    @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    {{ $editingId ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>
    @endif

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                @if (auth()->user()->role->name === 'HR')
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($branches as $branch)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $branch->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $branch->location ?? 'N/A' }}</td>
                    @if (auth()->user()->role->name === 'HR')
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <button wire:click="edit({{ $branch->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                            <button wire:click="delete({{ $branch->id }})" class="text-red-600 hover:text-red-900 ml-2">Delete</button>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>


</div>
