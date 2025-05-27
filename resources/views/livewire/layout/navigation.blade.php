<nav x-data="{ open: false }" class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Navigation Links -->
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-indigo-600">HR System</a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-4">
                    @if (auth()->user()->role->name === 'HR')
                        <a href="{{ route('hr-dashboard') }}"
                           class="{{ Route::is('hr-dashboard') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('hr-dashboard') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Dashboard
                        </a>
                        <a href="{{ route('divisions') }}"
                           class="{{ Route::is('divisions') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('divisions') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Divisions
                        </a>
                        <a href="{{ route('branches') }}"
                           class="{{ Route::is('branches') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('branches') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Branches
                        </a>
                        <a href="{{ route('payscales') }}"
                           class="{{ Route::is('payscales') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('payscales') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Payscales
                        </a>
                        <a href="{{ route('office-roles') }}"
                           class="{{ Route::is('office-roles') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('office-roles') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Office Roles
                        </a>
                        <a href="{{ route('users') }}"
                           class="{{ Route::is('users') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('users') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Users
                        </a>
                        <a href="{{ route('leave-requests') }}"
                           class="{{ Route::is('leave-requests') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('leave-requests') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Leave Requests
                        </a>
                        <a href="{{ route('attendance') }}"
                           class="{{ Route::is('attendance') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('attendance') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Attendance
                        </a>
                        <a href="{{ route('payroll') }}"
                           class="{{ Route::is('payroll') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('payroll') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Payroll
                        </a>
                        <a href="{{ route('reports') }}"
                           class="{{ Route::is('reports') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('reports') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Reports
                        </a>
                    @else
                        <a href="{{ route('employee-dashboard') }}"
                           class="{{ Route::is('employee-dashboard') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('employee-dashboard') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Dashboard
                        </a>
                        <a href="{{ route('leave-requests') }}"
                           class="{{ Route::is('leave-requests') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('leave-requests') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Leave Requests
                        </a>
                        <a href="{{ route('attendance') }}"
                           class="{{ Route::is('attendance') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('attendance') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Attendance
                        </a>
                        <a href="{{ route('payroll') }}"
                           class="{{ Route::is('payroll') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} inline-flex items-center px-3 py-2 border-b-4 {{ Route::is('payroll') ? 'border-indigo-500' : 'border-transparent' }} text-sm font-medium transition duration-150 ease-in-out">
                            Payroll
                        </a>
                    @endif
                </div>
            </div>

            <!-- User Info and Logout -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <div class="ml-3 relative flex items-center space-x-4">
                    <span class="text-gray-700 text-sm font-medium">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-indigo-600 text-sm font-medium transition duration-150 ease-in-out">Logout</button>
                    </form>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{ 'hidden': open, 'block': !open }">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{ 'block': open, 'hidden': !open }">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
        <div class="pt-2 pb-3 space-y-1">
            @if (auth()->user()->role->name === 'HR')
                <a href="{{ route('hr-dashboard') }}"
                   class="{{ Route::is('hr-dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('hr-dashboard') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Dashboard
                </a>
                <a href="{{ route('divisions') }}"
                   class="{{ Route::is('divisions') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('divisions') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Divisions
                </a>
                <a href="{{ route('branches') }}"
                   class="{{ Route::is('branches') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('branches') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Branches
                </a>
                <a href="{{ route('payscales') }}"
                   class="{{ Route::is('payscales') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('payscales') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Payscales
                </a>
                <a href="{{ route('office-roles') }}"
                   class="{{ Route::is('office-roles') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('office-roles') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Office Roles
                </a>
                <a href="{{ route('users') }}"
                   class="{{ Route::is('users') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('users') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Users
                </a>
                <a href="{{ route('leave-requests') }}"
                   class="{{ Route::is('leave-requests') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('leave-requests') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Leave Requests
                </a>
                <a href="{{ route('attendance') }}"
                   class="{{ Route::is('attendance') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('attendance') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Attendance
                </a>
                <a href="{{ route('payroll') }}"
                   class="{{ Route::is('payroll') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('payroll') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Payroll
                </a>
                <a href="{{ route('reports') }}"
                   class="{{ Route::is('reports') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('reports') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Reports
                </a>
            @else
                <a href="{{ route('employee-dashboard') }}"
                   class="{{ Route::is('employee-dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('employee-dashboard') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Dashboard
                </a>
                <a href="{{ route('leave-requests') }}"
                   class="{{ Route::is('leave-requests') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('leave-requests') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Leave Requests
                </a>
                <a href="{{ route('attendance') }}"
                   class="{{ Route::is('attendance') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('attendance') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Attendance
                </a>
                <a href="{{ route('payroll') }}"
                   class="{{ Route::is('payroll') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} block pl-3 pr-4 py-2 border-l-4 {{ Route::is('payroll') ? 'border-indigo-500' : 'border-transparent' }} text-base font-medium">
                    Payroll
                </a>
            @endif
            <div class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium">
                <span class="text-gray-700">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline-block ml-2">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-indigo-600">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
