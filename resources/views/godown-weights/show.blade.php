<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Godown Weight Details</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('godown-weights.edit', $godownWeight->id) }}" class="text-green-500 hover:text-green-600">Edit</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('godown-weights.index') }}" class="text-blue-500 hover:text-blue-600">Back to List</a>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Date</h2>
                    <p class="mt-1 text-sm text-gray-900">{{ $godownWeight->date->format('d M Y') }}</p>
                </div>

                <div>
                    <h2 class="text-sm font-medium text-gray-500">Remaining Weight</h2>
                    <p class="mt-1 text-sm text-gray-900">{{ number_format($godownWeight->remaining_weight, 2) }} Kg</p>
                </div>

                @if($godownWeight->notes)
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">Notes</h2>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $godownWeight->notes }}</p>
                    </div>
                @endif

                <div class="pt-4 border-t border-gray-200">
                    <h2 class="text-sm font-medium text-gray-500">Created At</h2>
                    <p class="mt-1 text-sm text-gray-900">{{ $godownWeight->created_at->format('d M Y, h:i A') }}</p>
                </div>

                <div>
                    <h2 class="text-sm font-medium text-gray-500">Last Updated</h2>
                    <p class="mt-1 text-sm text-gray-900">{{ $godownWeight->updated_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
