<x-app-layout>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-xl font-semibold mb-4">Weight Shortage Details</h2>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Driver:</label>
            <p class="text-gray-900">{{ $weightShortage->driver->name }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
            <p class="text-gray-900">{{ $weightShortage->date->format('M d, Y') }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Shortage Amount:</label>
            <p class="text-gray-900">{{ number_format($weightShortage->shortage_amount, 2) }} kg</p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Details:</label>
            <p class="text-gray-900 whitespace-pre-line">{{ $weightShortage->details }}</p>
        </div>

        <div class="flex items-center">
            <a href="{{ route('weight-shortages.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Back to List
            </a>
        </div>
    </div>
</x-app-layout>
