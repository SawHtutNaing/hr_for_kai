<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Employee Dashboard</h1>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-blue-100 p-4 rounded">
            <h3 class="text-lg font-medium">Total Hours This Month</h3>
            <p class="text-2xl">{{ auth()->user()->attendances()->whereMonth('date', now()->month)->sum('hours_worked') }}</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded">
            <h3 class="text-lg font-medium">Pending Leave Requests</h3>
            <p class="text-2xl">{{ auth()->user()->leaveRequests()->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-green-100 p-4 rounded">
            <h3 class="text-lg font-medium">Latest Payroll</h3>
            <p class="text-2xl">{{ auth()->user()->payrolls()->latest()->first()->amount ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Check In/Out -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Attendance</h2>
        @if ($canCheckIn)
            <button wire:click="checkIn" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Check In</button>
        @elseif ($canCheckOut)
            <button wire:click="checkOut" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Check Out</button>
        @else
            <p class="text-gray-500">You have already checked in and out for today.</p>
        @endif
    </div>

    <!-- Recent Attendance -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Recent Attendance</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hours Worked</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($attendances as $attendance)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->check_in }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->check_out ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->hours_worked ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recent Leave Requests -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Recent Leave Requests</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($leaveRequests as $leave)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $leave->start_date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $leave->end_date }}</td>
                        <td class="px-6 py-4">{{ $leave->reason }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $leave->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recent Payroll -->
    <div>
        <h2 class="text-xl font-semibold mb-4">Recent Payroll</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pay Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($payrolls as $payroll)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $payroll->pay_date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($payroll->amount, 2) }}</td>
                        <td class="px-6 py-4">{{ $payroll->details ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
