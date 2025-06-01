<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 font-sans">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Employee Dashboard</h1>

    @if (session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-50 p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-lg font-semibold text-gray-700">Total Hours This Month</h3>
            <p class="text-3xl font-bold text-blue-600">{{ auth()->user()->attendances()->whereMonth('date', now()->month)->sum('hours_worked') }}</p>
        </div>
        <div class="bg-yellow-50 p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-lg font-semibold text-gray-700">Pending Leave Requests</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ auth()->user()->leaveRequests()->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-green-50 p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-lg font-semibold text-gray-700">Latest Payroll</h3>
            <p class="text-3xl font-bold text-green-600">{{ auth()->user()->payrolls()->latest()->first()->amount ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Check In/Out -->
    <div class="mb-8 bg-white p-6 rounded-lg shadow-sm">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Attendance</h2>
        <div class="flex items-center space-x-4">
            <span class="text-sm font-medium text-gray-600">Today’s Status:
                <span class="font-bold {{ $todayStatus === 'Checked In' ? 'text-green-600' : ($todayStatus === 'Checked Out' ? 'text-red-600' : 'text-gray-500') }}">
                    {{ $todayStatus }}
                </span>
            </span>
            @if ($canCheckIn)
                <button wire:click="$dispatch('confirmCheckIn')" wire:loading.attr="disabled" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition disabled:opacity-50">
                    <span wire:loading class="animate-spin h-4 w-4 mr-2 inline-block">⏳</span>
                    Check In
                </button>
            @elseif ($canCheckOut)
                <button wire:click="$dispatch('confirmCheckOut')" wire:loading.attr="disabled" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition disabled:opacity-50">
                    <span wire:loading class="animate-spin h-4 w-4 mr-2 inline-block">⏳</span>
                    Check Out
                </button>
            @else
                <p class="text-gray-500 text-sm">You have already checked in and out for today.</p>
            @endif
        </div>
    </div>

    <!-- Recent Attendance -->
    <div class="mb-8 bg-white p-6 rounded-lg shadow-sm">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Attendance</h2>
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
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $attendance->date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $attendance->check_in }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $attendance->check_out ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $attendance->hours_worked ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recent Leave Requests -->
    <div class="mb-8">
        <div class="bg-white shadow-sm p-6 rounded-lg shadow-sm">
            <h3 class="text-xl font-semibold mb-4">Recent Leave Requests</h3>
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
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $leave->start_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $leave->end_date }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $leave->reason }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $leave->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Payroll -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Payroll</h2>
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
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $payroll->pay_date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ number_format($payroll->amount, 2) }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $payroll->details ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('confirmCheckIn', () => {
                    Swal.fire({
                        title: 'Confirm Check-In',
                        text: 'Are you sure you want to check in now?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Check In',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('checkIn');
                        }
                    });
                });

                Livewire.on('confirmCheckOut', () => {
                    Swal.fire({
                        title: 'Confirm Check-Out',
                        text: 'Are you sure you want to check out now?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Check Out',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('checkOut');
                        }
                    });
                });
            });
        </script>

</div>
