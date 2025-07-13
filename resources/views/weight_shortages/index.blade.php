<x-app-layout>
    <div class="content" x-data="weightShortages">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-primary-100 text-2xl font-bold">Weight Shortages</h1>
            <div>
                <x-input-label
                    for="selectedDate"
                    :value="__('Search by Date:')"
                    class="inline-block font-bold"
                />
                <x-text-input
                    id="selectedDate"
                    type="date"
                    @change="$event.target.value && (window.location.href = `?date=${selectedDate}`)"
                    x-model="selectedDate"
                />
                <span class="ml-4"><b>Today Date:</b> {{ now()->format('l, F j, Y') }}</span>
            </div>
        </div>

        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-full border">
                <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-left">Driver</th>
                    <th class="py-3 px-6 text-left">Shortage Amount</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                @foreach($shortages as $shortage)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left">{{ $shortage->date->format('M d, Y') }}</td>
                        <td class="py-3 px-6 text-left">{{ $shortage->driver->name }}</td>
                        <td class="py-3 px-6 text-left">{{ number_format($shortage->shortage_amount, 2) }} kg</td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('weight-shortages.show', $shortage->id) }}" class="mr-2 text-blue-500 hover:text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="{{ route('weight-shortages.edit', $shortage->id) }}" class="mr-2 text-green-500 hover:text-green-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                <x-delete-button :action="route('weight-shortages.destroy', $shortage->id)" itemName="this record" />
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
