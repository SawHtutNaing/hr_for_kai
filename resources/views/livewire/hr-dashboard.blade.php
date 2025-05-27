<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">HR Dashboard</h1>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-md mb-6 transition-all duration-300 ease-in-out">
            {{ session('message') }}
        </div>
    @endif

    <!-- Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <h3 class="text-lg font-medium text-gray-600">Total Employees</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $employeeCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <h3 class="text-lg font-medium text-gray-600">Pending Leave Requests</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ $pendingLeaveRequests->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <h3 class="text-lg font-medium text-gray-600">Total Payroll This Month</h3>
            <p class="text-3xl font-bold text-green-600">{{ number_format(App\Models\Payroll::whereMonth('pay_date', now()->month)->sum('amount'), 2) }}</p>
        </div>
    </div>

    <!-- Pending Leave Requests -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Pending Leave Requests</h2>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Start Date</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">End Date</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Reason</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($pendingLeaveRequests as $leave)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $leave->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $leave->start_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $leave->end_date }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $leave->reason }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button wire:click="approve({{ $leave->id }})" class="text-green-600 hover:text-green-800 font-medium transition-colors duration-200">Approve</button>
                                <button wire:click="reject({{ $leave->id }})" class="text-red-600 hover:text-red-800 font-medium ml-4 transition-colors duration-200">Reject</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Attendance -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Recent Attendance</h2>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Check In</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Check Out</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Hours Worked</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($recentAttendances as $attendance)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $attendance->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $attendance->date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $attendance->check_in }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $attendance->check_out ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $attendance->hours_worked ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Payroll -->
    <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Recent Payroll</h2>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Pay Date</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($recentPayrolls as $payroll)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $payroll->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $payroll->pay_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ number_format($payroll->amount, 2) }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $payroll->details ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
