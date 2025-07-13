<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchases Report - {{ $supplier->full_name }} - {{ $monthName }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>
<div class="header">
    <div class="title">Purchases from {{ $supplier->full_name }}</div>
    <div class="subtitle">Month: {{ $monthName }}</div>
</div>

<table style="margin-bottom: 15px">
    <tr class="info-row">
        <td>Mobile: {{ $supplier->mobile ?? 'N/A' }}</td>
        <td>Status: {{ $supplier->status ? 'Active' : 'Inactive' }}</td>
    </tr>
    <tr class="info-row">
        <td>Balance: {{ number_format($supplier->balance) }}</td>
        <td>Discount: {{ $supplier->discount }}</td>
    </tr>
</table>

<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Driver</th>
        <th>Vehicle</th>
        <th>Load Weight</th>
        <th>Net Weight</th>
        <th>Short Weight</th>
        <th>Rate</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($purchases as $purchase)
        <tr>
            <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</td>
            <td>{{ $purchase->driver_name }}</td>
            <td>{{ $purchase->vehicle_number }}</td>
            <td>{{ number_format($purchase->load_weight, 2) }} kg</td>
            <td>{{ number_format($purchase->net_weight, 2) }} kg</td>
            <td>{{ number_format($purchase->short_weight, 2) }} kg</td>
            <td>{{ $purchase->rate }}</td>
            <td>{{ number_format($purchase->amount) }}</td>
        </tr>
    @endforeach
    @if($purchases->isEmpty())
        <tr>
            <td colspan="8" style="text-align: center;">No purchases found for selected month.</td>
        </tr>
    @endif
    </tbody>
</table>
</body>
</html>
