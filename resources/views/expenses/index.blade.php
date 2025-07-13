<x-app-layout>
    <div class="container mx-auto px-4 py-8" x-data="{ selectedMonth: '{{ $selectedMonth }}' }">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800">My Expenses</h1>

            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                <!-- Month Picker -->
                <div class="relative">
                    <input
                        type="month"
                        x-model="selectedMonth"
                        @change="window.location.href = '{{ route('expenses.index') }}?month=' + selectedMonth"
                        class="block w-full px-8 py-2 h-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <a href="{{ route('expenses.create') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-300 whitespace-nowrap text-center">
                    Add New Expense
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-500 text-sm font-medium">Total Expenses</h3>
                <p class="text-2xl font-semibold">Rs {{ number_format($expenses->sum('amount'), 2) }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-500 text-sm font-medium">Average Daily</h3>
                <p class="text-2xl font-semibold">
                    Rs {{ number_format($expenses->sum('amount') / date('t', strtotime($selectedMonth)), 2) }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-500 text-sm font-medium">Number of Expenses</h3>
                <p class="text-2xl font-semibold">{{ $expenses->count() }}</p>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($expenses as $expense)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $expense->date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $expense->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $expense->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                Rs{{ number_format($expense->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('expenses.edit', $expense) }}"
                                       class="text-green-500 hover:text-green-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this expense?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No expenses found for this
                                month.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $expenses->appends(['month' => $selectedMonth])->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
