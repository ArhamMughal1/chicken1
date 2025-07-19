<x-app-layout>
{{--    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">--}}
{{--        <h2 class="text-xl font-semibold mb-4">Cash In Hand</h2>--}}

{{--        <form action="/cash_account/store" method="POST">--}}
{{--            <!-- CSRF Token (replace with actual token if needed) -->--}}
{{--            <input type="hidden" name="_token" value="YOUR_CSRF_TOKEN_HERE">--}}

{{--            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">--}}


{{--                <!-- Shortage Amount -->--}}
{{--                <div>--}}
{{--                    <label class="block text-gray-700 text-sm font-bold mb-2" for="shortage_amount">--}}
{{--                        Cash Available in Hand / Opening Balance--}}
{{--                    </label>--}}
{{--                    <input type="number" step="0.01" min="0" name="shortage_amount" id="shortage_amount" required--}}
{{--                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"--}}
{{--                           placeholder="Enter shortage amount">--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Details Textarea -->--}}
{{--            <div class="mb-6">--}}
{{--                <label class="block text-gray-700 text-sm font-bold mb-2" for="details">--}}
{{--                    Details--}}
{{--                </label>--}}
{{--                <textarea name="details" id="details" rows="4"--}}
{{--                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"--}}
{{--                          placeholder="Enter details about the the cash"></textarea>--}}
{{--            </div>--}}

{{--            <!-- Submit Buttons -->--}}
{{--            <div class="flex items-center justify-between">--}}
{{--                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">--}}
{{--                    Save Record--}}
{{--                </button>--}}
{{--                <a href="/weight-shortages" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">--}}
{{--                    Cancel--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}


    <div class="max-w-2xl mx-auto ">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-6">Create New Cash Account</h2>

            <form action="{{ route('cash-accounts.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                    <input type="number" step="0.01" name="amount" id="amount" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" id="date" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="details" class="block text-sm font-medium text-gray-700 mb-1">Details</label>
                    <textarea name="details" id="details" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                    @error('details')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('cash-accounts.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">Cancel</a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
