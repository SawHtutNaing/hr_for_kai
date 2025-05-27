<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Reports</h1>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (auth()->user()->role->name === 'HR')
        <form wire:submit.prevent="generateReport" class="mb-4">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Report Type</label>
                    <select wire:model="reportType" class="border rounded px-3 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="attendance">Attendance</option>
                        <option value="payroll">Payroll</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Employee</label>
                    <select wire:model="user_id" class="border rounded px-3 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Employees</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input wire:model="startDate" type="date" class="border rounded px-3 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">End Date</label>
                        <input wire:model="endDate" type="date" class="border rounded px-3 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Generate Report</button>
            </div>
        </form>

        @if ($reportType === 'attendance')
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
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $record->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $record->date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $record->check_in }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $record->check_out ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $record->hours_worked ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
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
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $record->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $record->pay_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($record->amount, 2) }}</td>
                            <td class="px-6 py-4">{{ $record->details ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="mt-4">
            {{-- {{ $reportData->links() }} --}}
        </div>
    @endif
</div>
