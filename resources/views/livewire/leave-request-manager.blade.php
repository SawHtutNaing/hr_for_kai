<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 font-sans">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Leave Requests</h1>

    @if (session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    @if (auth()->user()->role->name !== 'HR')
        <form wire:submit.prevent="create" class="mb-6 bg-white p-6 rounded-lg shadow-sm">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input wire:model="start_date" type="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">End Date</label>
                    <input wire:model="end_date" type="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Reason</label>
                    <textarea wire:model="reason" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    @error('reason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <button type="submit" wire:loading.attr="disabled" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition disabled:opacity-50">
                    <span wire:loading class="animate-spin-block h-4 w-4 mr-2">⏳</span>
                    Submit Request
                </button>
            </div>
        </form>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-sm">
        @if (auth()->user()->role->name === 'HR')
            <div class="flex justify-end mb-4">
                <button wire:click="prepareExport" wire:loading.attr="disabled" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition disabled:opacity-50">
                    <span wire:loading class="animate-spin-block h-4 w-4 mr-2">⏳</span>
                    Export to Excel
                </button>
            </div>
        @endif
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approved By</th>
                    @if (auth()->user()->role->name === 'HR')
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($leaveRequests as $leave)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $leave->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $leave->start_date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $leave->end_date }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $leave->reason }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $leave->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ optional($leave->approvedBy)->name ?? 'N/A' }}</td>
                        @if (auth()->user()->role->name === 'HR')
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                @if ($leave->status === 'pending')
                                    <button wire:click="approve({{ $leave->id }})" class="text-green-600 hover:text-green-800 mr-2">Approve</button>
                                    <button wire:click="reject({{ $leave->id }})" class="text-red-600 hover:text-red-800">Reject</button>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $leaveRequests->links() }}
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('exportFailed', ({ message }) => {
                    alert(message);
                });
            });
        </script>
    @endpush
</div>
