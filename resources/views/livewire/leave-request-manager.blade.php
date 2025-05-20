<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (auth()->user()->role->name === 'Employee')
        <form wire:submit.prevent="create" class="mb-4">
            <div class="space-y-4">
                <div>
                    <label>Start Date</label>
                    <input wire:model="start_date" type="date" class="border rounded px-3 py-2 w-full">
                    @error('start_date') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>End Date</label>
                    <input wire:model="end_date" type="date" class="border rounded px-3 py-2 w-full">
                    @error('end_date') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>Reason</label>
                    <textarea wire:model="reason" class="border rounded px-3 py-2 w-full"></textarea>
                    @error('reason') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Leave Request</button>
            </div>
        </form>
    @endif

    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left">Employee</th>
                <th class="px-6 py-3 text-left">Start Date</th>
                <th class="px-6 py-3 text-left">End Date</th>
                <th class="px-6 py-3 text-left">Reason</th>
                <th class="px-6 py-3 text-left">Status</th>
                @if (auth()->user()->role->name === 'HR')
                    <th class="px-6 py-3 text-right">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($leaveRequests as $leave)
                <tr>
                    <td class="px-6 py-4">{{ $leave->user->name }}</td>
                    <td class="px-6 py-4">{{ $leave->start_date }}</td>
                    <td class="px-6 py-4">{{ $leave->end_date }}</td>
                    <td class="px-6 py-4">{{ $leave->reason }}</td>
                    <td class="px-6 py-4">{{ $leave->status }}</td>
                    @if (auth()->user()->role->name === 'HR')
                        <td class="px-6 py-4 text-right">
                            @if ($leave->status === 'pending')
                                <button wire:click="approve({{ $leave->id }})" class="text-green-500">Approve</button>
                                <button wire:click="reject({{ $leave->id }})" class="text-red-500 ml-2">Reject</button>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
