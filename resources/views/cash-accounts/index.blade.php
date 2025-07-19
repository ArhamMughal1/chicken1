<x-app-layout>
    <div x-data="{ showModal: false, deleteId: null }">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Cash Accounts</h1>
            <a href="{{ route('cash-accounts.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                Add New
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($cashAccounts as $account)
                    <tr>
                        <td class="px-6 py-4">{{ $account->date->format('Y-m-d') }}</td>
                        <td class="px-6 py-4">{{ number_format($account->amount, 2) }}</td>
                        <td class="px-6 py-4">{{ Str::limit($account->details, 50) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('cash-accounts.show', $account) }}" class="text-blue-600 hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-eye"></i> <span>View</span>
                                </a>
                                <a href="{{ route('cash-accounts.edit', $account) }}" class="text-green-600 hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-pen-to-square"></i> <span>Edit</span>
                                </a>
                                <button @click="showModal = true; deleteId = {{ $account->id }}" class="text-red-600 hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-trash-can"></i> <span>Delete</span>
                                </button>
                            </div>
                        </td>


                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $cashAccounts->links() }}
        </div>

        <!-- Delete Confirmation Modal -->
        <div
            x-show="showModal"
            x-cloak
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        >
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4">
                    <div class="text-lg font-medium text-gray-900">Delete Cash Account</div>
                    <div class="mt-2 text-sm text-gray-600">
                        Are you sure you want to delete this cash account? This action cannot be undone.
                    </div>
                </div>
                <div class="px-6 py-4 flex justify-end space-x-3 bg-gray-100">
                    <form x-bind:action="'/cash-accounts/' + deleteId" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                    <button @click="showModal = false" class="bg-white text-gray-700 px-4 py-2 rounded border hover:bg-gray-200">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
