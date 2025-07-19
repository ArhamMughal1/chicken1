<x-app-layout>

{{--    <div class="max-w-2xl mx-auto">--}}
{{--        <div class="bg-white rounded-lg shadow p-6">--}}
{{--            <div class="flex justify-between items-start mb-6">--}}
{{--                <h2 class="text-xl font-semibold">Cash Account Details</h2>--}}
{{--                <div class="flex space-x-2">--}}
{{--                    <a href="{{ route('cash-accounts.edit', $cashAccount) }}" class="text-green-600 hover:text-green-900">Edit</a>--}}
{{--                    <form action="{{ route('cash-accounts.destroy', $cashAccount) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this account?')">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Delete</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="space-y-4">--}}
{{--                <div>--}}
{{--                    <h3 class="text-sm font-medium text-gray-500">Date</h3>--}}
{{--                    <p class="mt-1 text-sm text-gray-900">{{ $cashAccount->date->format('Y-m-d') }}</p>--}}
{{--                </div>--}}

{{--                <div>--}}
{{--                    <h3 class="text-sm font-medium text-gray-500">Amount</h3>--}}
{{--                    <p class="mt-1 text-sm text-gray-900">{{ number_format($cashAccount->amount, 2) }}</p>--}}
{{--                </div>--}}

{{--                @if($cashAccount->details)--}}
{{--                    <div>--}}
{{--                        <h3 class="text-sm font-medium text-gray-500">Details</h3>--}}
{{--                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $cashAccount->details }}</p>--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--                <div class="pt-4 border-t border-gray-200">--}}
{{--                    <a href="{{ route('cash-accounts.index') }}" class="text-blue-600 hover:text-blue-900">Back to list</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="container mx-auto px-6 py-8">


            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Cash Account</h1>
                <div class="mt-4 md:mt-0">
{{--                    <label for="selectedDate" class="text-sm font-medium text-gray-600 mr-2">Search by Date:</label>--}}
{{--                    <input type="date" id="selectedDate" class="border px-3 py-2 rounded-md shadow-sm" />--}}
                    <span class="ml-4 text-sm text-gray-700 font-semibold">
                         Today:  <span  class="mt-1 text-sm text-gray-900">{{ $cashAccount->date->format('Y-m-d') }}</span>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-10">
                <div class="bg-white p-6 rounded shadow h-auto">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Profit & Loss Summary</h3>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-gray-600">Cash In Hand</span>
                        <span class="text-green-600 font-bold">{{ number_format($cashAccount->amount, 2) }}</span>
                    </div>
                    <hr class="pt-3">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-gray-600">Total Sale</span>
                        <span class="text-red-500 font-bold">Rs {{$salesPaid ? number_format($salesPaid, 2) : 0}}</span>
                    </div>
                    <hr class="pt-3">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-gray-600">Today Expense</span>
                        <span class="text-red-500 font-bold">Rs {{$expense ? number_format($expense, 2) : 0}}</span>
                    </div>
                    <hr class="pt-3">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-gray-600">Net Profit Today</span>
                        <span class="text-green-600 font-bold">Rs {{ number_format($salesPaid - $purchasePaid - $expense, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center border-t pt-3 my-3">
                        <span class="text-gray-800 font-semibold">Total Balance Available</span>
                        <span class="text-blue-600 text-lg font-bold">Rs {{ number_format(($salesPaid + $cashAccount->amount) - $purchasePaid - $expense, 2)}}</span>
                    </div>
                    <hr class="pb-2 border-black">
                    @if($cashAccount->details)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Details</h3>
                            <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $cashAccount->details }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Summary KPIs -->
            <div class="grid grid-cols-3 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-6 rounded shadow h-auto">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Supplier Cash</h3>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-gray-600">Total Purchase</span>
                        <span class="text-green-600 font-bold">Rs {{number_format($purchase, 2)}}</span>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-gray-600">Amount Paid</span>
                        <span class="text-red-500 font-bold">Rs {{$purchasePaid ? number_format($purchasePaid, 2) : 0}}</span>
                    </div>
                    <div class="flex justify-between items-center border-t pt-3 mt-3">
                        <span class="text-gray-800 font-semibold">Remaining Balance</span>
                        <span class="text-blue-600 text-lg font-bold">Rs {{number_format($purchase - $purchasePaid, 2)}}</span>
                    </div>
                </div>
                <div class="bg-white p-6 rounded shadow h-auto">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Client Sale</h3>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-gray-600">Total Sale</span>
                        <span class="text-green-600 font-bold">Rs {{number_format($sales + $salesPaid, 2)}}</span>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-gray-600">Amount Recived</span>
                        <span class="text-red-500 font-bold">Rs {{$salesPaid ? number_format($salesPaid, 2) : 0}}</span>
                    </div>
                    <div class="flex justify-between items-center border-t pt-3 mt-3">
                        <span class="text-gray-800 font-semibold">Remaining Balance</span>
                        <span class="text-blue-600 text-lg font-bold">Rs {{number_format(($sales) , 2)}}</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded shadow h-auto">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Personal Expense</h3>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-gray-600">Today Expense</span>
                        <span class="text-green-600 font-bold">Rs {{$expense ? number_format($expense, 2) : 0}}</span>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-gray-600"><br></span>
                        <span class="text-green-600 font-bold"></span>
                    </div>
                    <div class="flex justify-between items-center border-t pt-3 mt-3">
                        <span class="text-gray-800 font-semibold">Total Expense</span>
                        <span class="text-blue-600 text-lg font-bold">Rs {{$expense ? number_format($expense, 2) : 0}}</span>
                    </div>
                </div>
            </div>


            <!-- Funnel Breakdown -->
{{--            <div class="bg-white rounded shadow p-6 mb-10">--}}
{{--                <h3 class="text-lg font-semibold text-gray-800 mb-4">Shortage Funnel Supplier</h3>--}}
{{--                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-center text-sm font-medium text-gray-700">--}}
{{--                    <!-- Card 1 -->--}}
{{--                    <div class="bg-gray-50 p-4 rounded shadow-sm">--}}
{{--                        <p>Weight Load</p>--}}
{{--                        <p class="text-2xl font-bold text-gray-900 mt-1">1,000 Kg</p>--}}
{{--                        <!-- Optional percentage -->--}}
{{--                        <!-- <p class="text-gray-500 mt-1">100%</p> -->--}}
{{--                    </div>--}}

{{--                    <!-- Card 2 -->--}}
{{--                    <div class="bg-gray-50 p-4 rounded shadow-sm">--}}
{{--                        <p>Weight Delivered</p>--}}
{{--                        <p class="text-2xl font-bold text-gray-900 mt-1">950 Kg</p>--}}
{{--                        <!-- <p class="text-gray-500 mt-1">95%</p> -->--}}
{{--                    </div>--}}

{{--                    <!-- Card 3 -->--}}
{{--                    <div class="bg-gray-50 p-4 rounded shadow-sm">--}}
{{--                        <p>Confirmed Shortages</p>--}}
{{--                        <p class="text-2xl font-bold text-gray-900 mt-1">50 Kg</p>--}}
{{--                        <!-- <p class="text-gray-500 mt-1">5%</p> -->--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--            <div class="bg-white rounded shadow p-6 mb-10">--}}
{{--                <h3 class="text-lg font-semibold text-gray-800 mb-4">Shortage Funnel Personal</h3>--}}
{{--                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-center text-sm font-medium text-gray-700">--}}
{{--                    <!-- Card 1 -->--}}
{{--                    <div class="bg-gray-50 p-4 rounded shadow-sm">--}}
{{--                        <p>Weight Available</p>--}}
{{--                        <p class="text-2xl font-bold text-gray-900 mt-1">950 Kg</p>--}}
{{--                        <!-- Optional percentage -->--}}
{{--                        <!-- <p class="text-gray-500 mt-1">100%</p> -->--}}
{{--                    </div>--}}

{{--                    <!-- Card 2 -->--}}
{{--                    <div class="bg-gray-50 p-4 rounded shadow-sm">--}}
{{--                        <p>Weight Delivered</p>--}}
{{--                        <p class="text-2xl font-bold text-gray-900 mt-1">930 Kg</p>--}}
{{--                        <!-- <p class="text-gray-500 mt-1">95%</p> -->--}}
{{--                    </div>--}}

{{--                    <!-- Card 3 -->--}}
{{--                    <div class="bg-gray-50 p-4 rounded shadow-sm">--}}
{{--                        <p>Confirmed Shortages</p>--}}
{{--                        <p class="text-2xl font-bold text-gray-900 mt-1">5 Kg</p>--}}
{{--                        <!-- <p class="text-gray-500 mt-1">5%</p> -->--}}
{{--                    </div>--}}

{{--                    <div class="bg-gray-50 p-4 rounded shadow-sm">--}}
{{--                        <p>Weight Dump</p>--}}
{{--                        <p class="text-2xl font-bold text-gray-900 mt-1">15 Kg</p>--}}
{{--                        <!-- <p class="text-gray-500 mt-1">5%</p> -->--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <a href="{{ route('cashAccount.report', ['date' => $cashAccount->date->format('Y-m-d')]) }}" target="_blank"
               class="inline-block bg-blue-600 text-white text-sm px-4 py-2 rounded-md shadow hover:bg-blue-700 transition duration-200">Download Report
            </a>
        </div>

</x-app-layout>
