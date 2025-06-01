<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 font-sans">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Reports</h1>

    @if (session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    @if (auth()->user()->role->name === 'HR')
        <form wire:submit.prevent="generateReport" class="mb-6 bg-white p-6 rounded-lg shadow-sm">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Report Type</label>
                    <select wire:model="reportType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="attendance">Attendance</option>
                        <option value="payroll">Payroll</option>
                    </select>
                    @error('reportType') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Employee</label>
                    <select wire:model="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">All Employees</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input wire:model="startDate" type="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('startDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">End Date</label>
                        <input wire:model="endDate" type="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('endDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" wire:loading.attr="disabled" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition disabled:opacity-50">
                        <span wire:loading class="animate-spin-block h-4 w-4 mr-2">⏳</span>
                        Generate Report
                    </button>
                    <button wire:click="prepareExport" type="button" wire:loading.attr="disabled" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition disabled:opacity-50">
                        <span wire:loading class="animate-spin-block h-4 w-4 mr-2">⏳</span>
                        Export to Excel
                    </button>
                </div>
            </div>
        </form>

        @if ($reportType === 'attendance')
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hours Worked</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($reportData as $record)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $record->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $record->date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $record->check_in }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $record->check_out ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $record->hours_worked ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pay Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($reportData as $record)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $record->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $record->pay_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ number_format($record->amount, 2) }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $record->details ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-4">
            {{ $reportData->links() }}
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
    @endif
</div>
