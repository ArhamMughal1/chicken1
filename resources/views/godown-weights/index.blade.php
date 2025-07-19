<x-app-layout>
    <div class="container mx-auto px-4 py-8" x-data="{ showModal: false, deleteId: null }">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Godown Weight Records</h1>
            <a href="{{ route('godown-weights.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition">
                Add New Record
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remaining Weight (Kg)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($weights as $weight)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $weight->date->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($weight->remaining_weight, 2) }}</td>
                        <td class="px-6 py-4">{{ Str::limit($weight->notes, 50) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                if($weight->used == 1){
                                    $purchase = App\Models\Purchase::where('godown', $weight->id)->first();
                                }else{
                                    $purchase = null;
                                }
                                
                            @endphp
                            @if ($purchase)
                                <a href="/supplier-ledger?date={{date("Y-m-d", strtotime($purchase->purchase_date))}}" class="text-blue-500 hover:text-blue-600 mr-3">View Purchase</a>
                            @endif
                            
                            <a href="{{ route('godown-weights.show', $weight->id) }}" class="text-blue-500 hover:text-blue-600 mr-3">View</a>
                            <a href="{{ route('godown-weights.edit', $weight->id) }}" class="text-green-500 hover:text-green-600 mr-3">Edit</a>
                            <button @click="showModal = true; deleteId = {{ $weight->id }}" class="text-red-500 hover:text-red-600">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No weight records found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $weights->links() }}
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4 z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full" @click.away="showModal = false">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Deletion</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this godown weight record? This action cannot be undone.</p>
                <div class="flex justify-end space-x-3">
                    <button @click="showModal = false" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <form :action="'{{ route('godown-weights.destroy', '') }}/' + deleteId" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
