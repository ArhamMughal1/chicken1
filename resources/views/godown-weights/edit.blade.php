<x-app-layout>
    <!-- resources/views/godown-weights/edit.blade.php -->
    @extends('layouts.app')

    @section('content')
        <div class="container mx-auto px-4 py-8" x-data="godownWeightForm()">
            <div class="max-w-2xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Update Daily Godown Weight</h1>
                    <a href="{{ route('godown-weights.index') }}" class="text-blue-500 hover:text-blue-600 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Daily Records
                    </a>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        Please correct the errors below
                    </div>
                @endif

                <!-- Daily Weight Form -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <form @submit.prevent="submitForm" method="POST" action="{{ route('godown-weights.update', $godownWeight->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="p-6 space-y-6">
                            <!-- Date (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Transaction Date
                                </label>
                                <div class="p-2 bg-gray-100 rounded-md">
                                    {{ $godownWeight->date->format('D, d M Y') }}
                                </div>
                            </div>

                            <!-- Previous Day's Weight -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Previous Weight (Kg)
                                </label>
                                <div class="p-2 bg-gray-100 rounded-md">
                                    {{ number_format($previousWeight ?? 0, 2) }} Kg
                                </div>
                            </div>

                            <!-- Today's Remaining Weight -->
                            <div>
                                <label for="remaining_weight" class="block text-sm font-medium text-gray-700 mb-1">
                                    Today's Remaining Weight (Kg) *
                                </label>
                                <input type="number" step="0.01" name="remaining_weight" id="remaining_weight"
                                       x-model="formData.remaining_weight"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('remaining_weight')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Supplier Transaction Details -->
                            <div class="border-t pt-4 mt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Supplier Transaction</h3>

                                <!-- Purchased Today -->
                                <div class="mb-4">
                                    <label for="purchased" class="block text-sm font-medium text-gray-700 mb-1">
                                        Purchased Today (Kg)
                                    </label>
                                    <input type="number" step="0.01" name="purchased" id="purchased"
                                           x-model="formData.purchased"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('purchased')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Sold Today -->
                                <div class="mb-4">
                                    <label for="sold" class="block text-sm font-medium text-gray-700 mb-1">
                                        Sold Today (Kg)
                                    </label>
                                    <input type="number" step="0.01" name="sold" id="sold"
                                           x-model="formData.sold"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('sold')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                    Transaction Notes
                                </label>
                                <textarea name="notes" id="notes" rows="3"
                                          x-model="formData.notes"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="E.g., Supplier name, quality notes, etc."></textarea>
                                @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Footer -->
                        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                            <div class="text-sm text-gray-500">
                                Last updated: {{ $godownWeight->updated_at->format('d M Y, h:i A') }}
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('godown-weights.index') }}"
                                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                                    Cancel
                                </a>
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Update Daily Record
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function godownWeightForm() {
                return {
                    formData: {
                        remaining_weight: {{ old('remaining_weight', $godownWeight->remaining_weight) }},
                        purchased: {{ old('purchased', $godownWeight->purchased ?? 0) }},
                        sold: {{ old('sold', $godownWeight->sold ?? 0) }},
                        notes: `{{ old('notes', $godownWeight->notes) }}`
                    },
                    submitForm() {
                        // Validate that remaining weight is positive
                        if (this.formData.remaining_weight < 0) {
                            alert('Remaining weight cannot be negative');
                            return false;
                        }

                        // Validate purchased/sold are positive numbers if provided
                        if (this.formData.purchased < 0 || this.formData.sold < 0) {
                            alert('Purchased and sold quantities must be positive numbers');
                            return false;
                        }

                        this.$el.submit();
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
