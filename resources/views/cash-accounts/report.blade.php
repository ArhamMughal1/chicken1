<!DOCTYPE html>
<html>
<head>
    <title>Cash Account Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 6px;
        }
        h1, h3 {
            margin: 0;
            padding-bottom: 10px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .row span {
            display: inline-block;
        }
        .label {
            color: #555;
        }
        .value {
            font-weight: bold;
        }
        .value.green {
            color: green;
        }
        .value.red {
            color: red;
        }
        .value.blue {
            color: blue;
        }
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="section">
        <span style="font-size: 32px; font-weight: 600">Cash Account</span>
        <span><strong>Today:</strong> {{ $cashAccount->date->format('Y-m-d') }}</span>
    </div>

    <!-- Profit & Loss Summary -->
    <div class="section">
        <h3>Profit & Loss Summary</h3>
        <div class="row">
            <span class="label">Cash In Hand</span>
            <span class="value green">Rs {{ number_format($cashAccount->amount, 2) }}</span>
        </div>
        <hr>
        <div class="row">
            <span class="label">Total Sale</span>
            <span class="value red">Rs {{ $salesPaid ? number_format($salesPaid, 2) : 0 }}</span>
        </div>
        <hr>
        <div class="row">
            <span class="label">Today Expense</span>
            <span class="value red">Rs {{ $expense ? number_format($expense, 2) : 0 }}</span>
        </div>
        <hr>
        <div class="flex justify-between items-center mb-3">
            <span class="label">Net Profit Today</span>
            <span class="value green">Rs {{ number_format($salesPaid - $purchasePaid - $expense, 2) }}</span>
        </div>
        <hr>
        <div class="row">
            <span class="label"><strong>Total Balance Available</strong></span>
            <span class="value blue">Rs {{ number_format(($salesPaid + $cashAccount->amount) - $purchasePaid - $expense, 2) }}</span>
        </div>
        <hr>
        @if($cashAccount->details)
            <div>
                <h4>Details</h4>
                <p style="white-space: pre-line;">{{ $cashAccount->details }}</p>
            </div>
        @endif
    </div>

    <!-- Supplier Cash -->
    <div class="section">
        <h3>Supplier Cash</h3>
        <div class="row">
            <span class="label">Total Purchase</span>
            <span class="value green">Rs {{ number_format($purchase, 2) }}</span>
        </div>
        <div class="row">
            <span class="label">Amount Paid</span>
            <span class="value red">Rs {{ $purchasePaid ? number_format($purchasePaid, 2) : 0 }}</span>
        </div>
        <hr>
        <div class="row">
            <span class="label"><strong>Remaining Balance</strong></span>
            <span class="value blue">Rs {{ number_format($purchase - $purchasePaid, 2) }}</span>
        </div>
    </div>

    <!-- Client Sale -->
    <div class="section">
        <h3>Client Sale</h3>
        <div class="row">
            <span class="label">Total Sale</span>
            <span class="value green">Rs {{ number_format($sales + $salesPaid, 2) }}</span>
        </div>
        <div class="row">
            <span class="label">Amount Received</span>
            <span class="value red">Rs {{ $salesPaid ? number_format($salesPaid, 2) : 0 }}</span>
        </div>
        <hr>
        <div class="row">
            <span class="label"><strong>Remaining Balance</strong></span>
            <span class="value blue">Rs {{ number_format($sales, 2) }}</span>
        </div>
    </div>

    <!-- Personal Expense -->
    <div class="section">
        <h3>Personal Expense</h3>
        <div class="row">
            <span class="label">Today Expense</span>
            <span class="value green">Rs {{ $expense ? number_format($expense, 2) : 0 }}</span>
        </div>
        <hr>
        <div class="row">
            <span class="label"><strong>Total Expense</strong></span>
            <span class="value blue">Rs {{ $expense ? number_format($expense, 2) : 0 }}</span>
        </div>
    </div>
</div>
</body>
</html>
