<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cash Account Daily Report</title>
    <style>
        @page {
            margin: 60px 40px 60px;
        }

        @font-face {
            font-family: 'Jameel Noori Nastaleeq';
            src: url('{{ storage_path('fonts/JameelNooriNastaleeq.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'NotoNastaliqUrdu';
            src: url('{{ storage_path('fonts/NotoNastaliqUrdu-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'NotoNastaliqUrdu', sans-serif;
            margin: 0;
        }

        .avoid-page-break {
            page-break-inside: avoid;
        }

        /* Main table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            /* Essential for proper borders */
            margin: 10px 0;
            font-family: 'Jameel Noori Nastaleeq', sans-serif;
            direction: rtl;
        }

        /* Cell borders */
        th,
        td {
            border: 1px solid #777777;
            /* Solid black border */
            padding: 8px;
            text-align: right;
            /* Right align for RTL */
        }

        /* Header styling */
        th {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-6">
                <h2 class="text-xl font-semibold">Cash Account Details</h2>
                <div class="flex space-x-2">
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Date</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $cashAccount->date->format('Y-m-d') }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Amount</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ number_format($cashAccount->amount, 2) }}</p>
                </div>

                @if($cashAccount->details)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Details</h3>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $cashAccount->details }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-8">


        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Cash Account</h1>
            <div class="mt-4 md:mt-0">
                {{-- <label for="selectedDate" class="text-sm font-medium text-gray-600 mr-2">Search by
                    Date:</label>--}}
                {{-- <input type="date" id="selectedDate" class="border px-3 py-2 rounded-md shadow-sm" />--}}
                <span class="ml-4 text-sm text-gray-700 font-semibold">
                    Today: <span class="mt-1 text-sm text-gray-900">{{ $cashAccount->date->format('Y-m-d') }}</span>
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
                <div class="flex justify-between items-center border-t pt-3 my-3">
                    <span class="text-gray-800 font-semibold">Net Balance</span>
                    <span class="text-blue-600 text-lg font-bold">Rs
                        {{ number_format(($salesPaid + $cashAccount->amount) - $purchasePaid - $expense, 2)}}</span>
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
                    <span class="text-red-500 font-bold">Rs
                        {{$purchasePaid ? number_format($purchasePaid, 2) : 0}}</span>
                </div>
                <div class="flex justify-between items-center border-t pt-3 mt-3">
                    <span class="text-gray-800 font-semibold">Remaining Balance</span>
                    <span class="text-blue-600 text-lg font-bold">Rs
                        {{number_format($purchase - $purchasePaid, 2)}}</span>
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
                    <span class="text-blue-600 text-lg font-bold">Rs {{number_format(($sales), 2)}}</span>
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
                    <span class="text-blue-600 text-lg font-bold">Rs
                        {{$expense ? number_format($expense, 2) : 0}}</span>
                </div>
            </div>
        </div>
    </div>