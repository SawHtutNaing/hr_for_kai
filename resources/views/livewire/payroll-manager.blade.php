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
                    <label>Employee</label>
                    <select wire:model="user_id" class="border rounded px-3 py-2 w-full">
                        <option value="">Select Employee</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>Amount</label>
                    <input wire:model="amount" type="number" step="0.01" class="border rounded px-3 py-2 w-full">
                    @error('amount') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>Pay Date</label>
                    <input wire:model="pay_date" type="date" class="border rounded px-3 py-2 w-full">
                    @error('pay_date') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>Details</label>
                    <textarea wire:model="details" class="border rounded px-3 py-2 w-full"></textarea>
                    @error('details') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Payroll</button>
            </div>
        </form>
    @endif

    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left">Employee</th>
                <th class="px-6 py-3 text-left">Amount</th>
                <th class="px-6 py-3 text-left">Pay Date</th>
                <th class="px-6 py-3 text-left">Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payrolls as $payroll)
                <tr>
                    <td class="px-6 py-4">{{ $payroll->user->name }}</td>
                    <td class="px-6 py-4">{{ $payroll->amount }}</td>
                    <td class="px-6 py-4">{{ $payroll->pay_date }}</td>
                    <td class="px-6 py-4">{{ $payroll->details ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
