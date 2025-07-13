<x-app-layout>
    <div class="container mx-auto px-6 py-8">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Cash Account</h1>
            <div class="mt-4 md:mt-0">
                <label for="selectedDate" class="text-sm font-medium text-gray-600 mr-2">Search by Date:</label>
                <input type="date" id="selectedDate" class="border px-3 py-2 rounded-md shadow-sm" />
                <span class="ml-4 text-sm text-gray-700 font-semibold">
                     Today: <span class="text-gray-900 font-bold">Saturday, July 5, 2025</span>
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-10">
            <div class="bg-white p-6 rounded shadow h-auto">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Profit & Loss Summary</h3>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600">Cash In Hand</span>
                    <span class="text-green-600 font-bold">Rs 10,000</span>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600">Total Sale</span>
                    <span class="text-red-500 font-bold">Rs 435,750</span>
                </div>
                <div class="flex justify-between items-center border-t pt-3 mt-3">
                    <span class="text-gray-800 font-semibold">Net Balance</span>
                    <span class="text-blue-600 text-lg font-bold">Rs 16,250</span>
                </div>
            </div>
        </div>

        <!-- Summary KPIs -->
        <div class="grid grid-cols-3 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded shadow h-auto">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Supplier Cash</h3>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600">Total Purchase</span>
                    <span class="text-green-600 font-bold">Rs 427,500</span>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600">Amount Paid</span>
                    <span class="text-red-500 font-bold">Rs 427,500</span>
                </div>
                <div class="flex justify-between items-center border-t pt-3 mt-3">
                    <span class="text-gray-800 font-semibold">Remaining Balance</span>
                    <span class="text-blue-600 text-lg font-bold">Rs 0</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded shadow h-auto">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Client Sale</h3>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600">Total Sale</span>
                    <span class="text-green-600 font-bold">Rs 435,750</span>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600">Amount Recived</span>
                    <span class="text-red-500 font-bold">Rs 435,750</span>
                </div>
                <div class="flex justify-between items-center border-t pt-3 mt-3">
                    <span class="text-gray-800 font-semibold">Remaining Balance</span>
                    <span class="text-blue-600 text-lg font-bold">Rs 0</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded shadow h-auto">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Personal Expense</h3>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600">Today Expense</span>
                    <span class="text-green-600 font-bold">Rs 2,000</span>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600"><br></span>
                    <span class="text-green-600 font-bold"></span>
                </div>
                <div class="flex justify-between items-center border-t pt-3 mt-3">
                    <span class="text-gray-800 font-semibold">Total Expense</span>
                    <span class="text-blue-600 text-lg font-bold">Rs 2,000</span>
                </div>
            </div>
        </div>


        <!-- Funnel Breakdown -->
        <div class="bg-white rounded shadow p-6 mb-10">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Shortage Funnel Supplier</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-center text-sm font-medium text-gray-700">
                <!-- Card 1 -->
                <div class="bg-gray-50 p-4 rounded shadow-sm">
                    <p>Weight Load</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">1,000 Kg</p>
                    <!-- Optional percentage -->
                    <!-- <p class="text-gray-500 mt-1">100%</p> -->
                </div>

                <!-- Card 2 -->
                <div class="bg-gray-50 p-4 rounded shadow-sm">
                    <p>Weight Delivered</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">950 Kg</p>
                    <!-- <p class="text-gray-500 mt-1">95%</p> -->
                </div>

                <!-- Card 3 -->
                <div class="bg-gray-50 p-4 rounded shadow-sm">
                    <p>Confirmed Shortages</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">50 Kg</p>
                    <!-- <p class="text-gray-500 mt-1">5%</p> -->
                </div>
            </div>

        </div>
        <div class="bg-white rounded shadow p-6 mb-10">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Shortage Funnel Personal</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-center text-sm font-medium text-gray-700">
                <!-- Card 1 -->
                <div class="bg-gray-50 p-4 rounded shadow-sm">
                    <p>Weight Available</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">950 Kg</p>
                    <!-- Optional percentage -->
                    <!-- <p class="text-gray-500 mt-1">100%</p> -->
                </div>

                <!-- Card 2 -->
                <div class="bg-gray-50 p-4 rounded shadow-sm">
                    <p>Weight Delivered</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">930 Kg</p>
                    <!-- <p class="text-gray-500 mt-1">95%</p> -->
                </div>

                <!-- Card 3 -->
                <div class="bg-gray-50 p-4 rounded shadow-sm">
                    <p>Confirmed Shortages</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">5 Kg</p>
                    <!-- <p class="text-gray-500 mt-1">5%</p> -->
                </div>

                <div class="bg-gray-50 p-4 rounded shadow-sm">
                    <p>Weight Dump</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">15 Kg</p>
                    <!-- <p class="text-gray-500 mt-1">5%</p> -->
                </div>
            </div>
        </div>
        <a href=""
           class="inline-block bg-blue-600 text-white text-sm px-4 py-2 rounded-md shadow hover:bg-blue-700 transition duration-200">Download Report
        </a>
    </div>
</x-app-layout>
