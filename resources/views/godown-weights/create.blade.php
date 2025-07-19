<x-app-layout>
    @props(['weight' => null])

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">{{ $weight ? 'Edit' : 'Add New' }} Godown Weight Record</h2>

            <form method="POST" action="{{ $weight ? route('godown-weights.update', $weight->id) : route('godown-weights.store') }}">
                @csrf
                @if($weight) @method('PUT') @endif

                <div class="mb-4">
                    <label for="remaining_weight" class="block text-sm font-medium text-gray-700 mb-1">Remaining Weight (Kg)</label>
                    <input type="number" step="0.01" name="remaining_weight" id="remaining_weight"
                           value="{{ old('remaining_weight', $weight?->remaining_weight) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('remaining_weight')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" id="date"
                           value="{{ old('date', $weight?->date?->format('Y-m-d')) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $weight?->notes) }}</textarea>
                    @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('godown-weights.index') }}" class="mr-3 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        {{ $weight ? 'Update' : 'Save' }} Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
