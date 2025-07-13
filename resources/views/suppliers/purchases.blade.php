<x-app-layout>
    <div class="py-6 px-4 max-w-7xl mx-auto" x-data="{
        selectedMonth: '{{ $selectedMonth }}',
        init() {
            // Set up any initial Alpine.js functionality if needed
        }
    }">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Purchases from {{ $supplier->full_name }}</h1>
            <a href="{{ route('supplier.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition">
                Back to Suppliers
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="p-4 bg-gray-50 border-b">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div>
                        <p class="text-gray-600">Mobile: {{ $supplier->mobile ?? 'N/A' }}</p>
                        <p class="text-gray-600">Current Balance: {{ number_format($supplier->balance) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600">Discount: Rs {{ $supplier->discount }}</p>
                        <p class="text-gray-600">Status:
                            <span class="{{ $supplier->status ? 'text-green-600' : 'text-red-600' }}">
                                {{ $supplier->status ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Month Filter -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" action="{{ route('suppliers.purchases', $supplier) }}" class="flex items-center space-x-4">
                    <label for="month-filter" class="text-gray-700 font-medium">Filter by Month:</label>
                    <input
                        type="month"
                        id="month-filter"
                        name="month"
                    x-model="selectedMonth"
                    value="{{ $selectedMonth }}"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    >
                    <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                        Filter
                    </button>
                    @if(request('month'))
                        <a href="{{ route('suppliers.purchases', $supplier) }}" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                            Reset
                        </a>
                    @endif

                <!-- PDF Download Button -->
                <a href="{{ route('suppliers.purchases.report', ['supplier' => $supplier, 'month' => request('month')]) }}"
                   class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download PDF
                </a>
            </form>
        </div>

        <!-- Purchases Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Driver</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Load Weight</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Weight</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Short Weight</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($purchases as $purchase)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $purchase->driver_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $purchase->vehicle_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($purchase->load_weight, 2) }} kg
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($purchase->net_weight, 2) }} kg
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($purchase->short_weight, 2) }} kg
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $purchase->rate }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($purchase->amount) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                No purchases found for selected month.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
