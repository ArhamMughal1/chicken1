<x-app-layout>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-xl font-semibold mb-4">Record Weight Shortage</h2>

        <form action="{{ route('weight-shortages.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="driver_id">
                        Driver
                    </label>
                    <select name="driver_id" id="driver_id" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-black bg-white leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                {{ $driver->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('driver_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                        Date
                    </label>
                    <input type="date" name="date" id="date" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           value="{{ old('date', now()->format('Y-m-d')) }}">
                    @error('date')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="shortage_amount">
                        Shortage Amount (kg)
                    </label>
                    <input type="number" step="0.01" min="0" name="shortage_amount" id="shortage_amount" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           placeholder="Enter shortage amount" value="{{ old('shortage_amount') }}">
                    @error('shortage_amount')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>


            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="details">
                    Details
                </label>
                <textarea name="details" id="details" rows="4"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline"
                          placeholder="Enter details about the shortage">{{ old('details') }}</textarea>
                @error('details')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <button type="submit" class=" mr-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Save Record
                </button>
                <a href="{{ route('weight-shortages.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-700 hover:text-black">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
