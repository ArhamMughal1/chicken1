<x-app-layout>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Drivers Management</h1>

    <div class="mb-4 flex justify-end">
        <a href="{{ route('drivers.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Add New Driver
        </a>
    </div>

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full border">
            <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">Details</th>
                <th class="py-3 px-6 text-center">Actions</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
            @foreach($drivers as $driver)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $driver->name }}</td>
                    <td class="py-3 px-6 text-left">{{ Str::limit($driver->details, 50) }}</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex items-center justify-center space-x-4">
                            {{-- View --}}
                            <a href="{{ route('drivers.show', $driver->id) }}" class="flex items-center text-blue-500 hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                          d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                                View
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('drivers.edit', $driver->id) }}" class="flex items-center text-green-500 hover:text-green-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                                Edit
                            </a>

                            {{-- Delete --}}


                                <!-- Confirmation Modal -->
                                @php
                                    $itemName = 'driver ' . $driver->name;
                                @endphp

                                <div x-data="{ open: false }" class="inline-block">
                                    <!-- Trigger Button -->
                                    <button @click="open = true" type="button" class="text-red-500 hover:text-red-700">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Delete
                                    </button>

                                    <!-- Confirmation Modal -->
                                    <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                        <div class="bg-white p-4 rounded shadow w-72">
                                            <p class="text-gray-800 mb-4">
                                                Are you sure you want to delete <strong>{{ $itemName }}</strong>?
                                            </p>
                                            <div class="flex justify-center gap-2">
                                                <button @click="open = false" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                                                <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $drivers->links() }}
    </div>
</x-app-layout>
