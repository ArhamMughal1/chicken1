<x-app-layout>
    <div class="py-6 px-4 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Sales for {{ $client->full_name }}</h1>
            <a href="{{ route('client.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition">
                Back to Clients
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="p-4 bg-gray-50 border-b">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div>
                        <p class="text-gray-600">Mobile: {{ $client->mobile ?? 'N/A' }}</p>
                        <p class="text-gray-600">Discount: {{ $client->discount }}</p>
                        <p class="text-gray-600">Current Balance: {{ number_format($client->balance) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600 capitalize">Category: {{ $client->category }}</p>
                        <p class="text-gray-600">Status:
                            <span class="{{ $client->status ? 'text-green-600' : 'text-red-600' }}">
                                {{ $client->status ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Month Filter -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" action="{{ route('clients.sales', $client) }}">
                <div class="flex items-center space-x-4">
                    <label for="month-filter" class="text-gray-700 font-medium">Filter by Month:</label>
                    <input
                        type="month"
                        id="month-filter"
                        name="month"
                        value="{{ request('month') ?? date('Y-m') }}"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    >
                    <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                        Filter
                    </button>
                    @if(request('month'))
                        <a href="{{ route('clients.sales', $client) }}" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                            Reset
                        </a>
                    @endif
                </div>

                <a href="{{ route('clients.sales.report', ['client' => $client, 'month' => request('month')]) }}"
                   class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition flex items-center"
                   x-data="{ loading: false }"
                   @click="loading = true"
                   :class="{ 'opacity-75 cursor-not-allowed': loading }">
                    <svg x-show="!loading" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <svg x-show="loading" class="animate-spin -ml-1 mr-1 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Download PDF
                </a>
            </form>
        </div>

        <!-- Sales Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Arrears</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Arrears</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($sales as $sale)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->weight }} kg</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->rate }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($sale->amount) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($sale->amount_paid) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($sale->arrears) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($sale->total_arrears) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                No sales found {{ request('month') ? 'for selected month' : '' }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
