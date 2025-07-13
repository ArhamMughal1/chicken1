<div x-data="confirmDelete('{{ $action }}')">
    <button @click="confirmedDelete()" type="button" class="text-red-500 hover:text-red-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Modal -->
    <div x-show="isOpen" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50" x-cloak>
        <div class="bg-white rounded-lg p-6 max-w-sm w-full shadow-xl" @click.away="isOpen = false">
            <h3 class="text-lg font-medium mb-4">Confirm Deletion</h3>
            <p class="mb-6">Are you sure you want to delete {{ $itemName }}? This action cannot be undone.</p>
            <div class="flex justify-end space-x-3">
                <button @click="isOpen = false"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button @click="submitForm"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
