<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (auth()->user()->role->name === 'HR')
        <form wire:submit.prevent="create" class="mb-4">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Employee</label>
                    <select wire:model="user_id" class="border rounded px-3 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Employee</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pay Date</label>
                    <input wire:model="pay_date" type="date" class="border rounded px-3 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500">
                    @error('pay_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Details</label>
                    <textarea wire:model="details" class="border rounded px-3 py-2 w-full focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    @error('details') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Create Payroll</button>
            </div>
        </form>
    @endif

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
            @foreach ($payrolls as $payroll)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payroll->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payroll->pay_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($payroll->amount, 2) }}</td>
                    <td class="px-6 py-4">{{ $payroll->details ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{-- {{ $payrolls->links() }} --}}
    </div>
</div>
