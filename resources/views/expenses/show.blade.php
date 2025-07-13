<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Expense Details</h2>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900">{{ $expense->description }}</h3>
                    <p class="text-sm text-gray-500">{{ $expense->date->format('F j, Y') }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Amount</p>
                        <p class="text-xl font-semibold text-gray-900">${{ number_format($expense->amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Category</p>
                        <p class="text-lg text-gray-900">{{ $expense->category }}</p>
                    </div>
                </div>

                @if($expense->notes)
                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-500 mb-1">Notes</p>
                        <p class="text-gray-700 whitespace-pre-line">{{ $expense->notes }}</p>
                    </div>
                @endif

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('expenses.edit', $expense) }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this expense?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </x-app-layout>
