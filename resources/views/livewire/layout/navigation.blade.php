<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    {{-- <a href="{{ route('dashboard') }}">HR System --}}

                    </a>
                </div>
                <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                    @if (auth()->user()->role->name === 'HR')
                        <a href="{{ route('divisions') }}" class="border-indigo-500 text-gray-900">Divisions</a>
                        <a href="{{ route('branches') }}" class="border-indigo-500 text-gray-900">Branches</a>
                        <a href="{{ route('payscales') }}" class="border-indigo-500 text-gray-900">Payscales</a>
                        <a href="{{ route('office-roles') }}" class="border-indigo-500 text-gray-900">Office Roles</a>
                        <a href="{{ route('users') }}" class="border-indigo-500 text-gray-900">Users</a>
                    @endif
                    <a href="{{ route('leave-requests') }}" class="border-indigo-500 text-gray-900">Leave Requests</a>
                    <a href="{{ route('attendance') }}" class="border-indigo-500 text-gray-900">Attendance</a>
                    <a href="{{ route('payroll') }}" class="border-indigo-500 text-gray-900">Payroll</a>
                </div>
            </div>
        </div>
    </div>
</nav>
