<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (auth()->user()->role->name === 'Employee')
        <div class="mb-4">
            <button wire:click="checkIn" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Check In</button>
            <button wire:click="checkOut" class="bg-red-500 text-white px-4 py-2 rounded">Check Out</button>
        </div>
    @endif

    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left">Employee</th>
                <th class="px-6 py-3 text-left">Date</th>
                <th class="px-6 py-3 text-left">Check In</th>
                <th class="px-6 py-3 text-left">Check Out</th>
                <th class="px-6 py-3 text-left">Hours Worked</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
                <tr>
                    <td class="px-6 py-4">{{ $attendance->user->name }}</td>
                    <td class="px-6 py-4">{{ $attendance->date }}</td>
                    <td class="px-6 py-4">{{ $attendance->check_in }}</td>
                    <td class="px-6 py-4">{{ $attendance->check_out }}</td>
                    <td class="px-6 py-4">{{ $attendance->hours_worked ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
