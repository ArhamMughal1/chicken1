<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report - {{ $client->full_name }} - {{ $monthName }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 14px; }
        .info-row { margin-bottom: 5px; }
    </style>
</head>
<body>
<div class="header">
    <div class="title">Sales to {{ $client->full_name }}</div>
    <div class="subtitle">Month: {{ $monthName }}</div>
</div>

<table style="margin-bottom: 15px;">
    <tr class="info-row">
        <td>Mobile: {{ $client->mobile ?? 'N/A' }}</td>
        <td>Status: {{ $client->status ? 'Active' : 'Inactive' }}</td>
    </tr>
    <tr class="info-row">
        <td>Balance: {{ number_format($client->balance) }}</td>
        <td>Discount: {{ $client->discount }}</td>
    </tr>
</table>

<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Type</th>
        <th>Weight</th>
        <th>Rate</th>
        <th>Amount</th>
        <th>Paid</th>
        <th>Arrears</th>
        <th>Total Arrears</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($sales as $sale)
        <tr>
            <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}</td>
            <td>{{ ucfirst($sale->sale_type) }}</td>
            <td>{{ $sale->weight }} kg</td>
            <td>{{ $sale->rate }}</td>
            <td>{{ number_format($sale->amount) }}</td>
            <td>{{ number_format($sale->amount_paid) }}</td>
            <td>{{ number_format($sale->arrears) }}</td>
            <td>{{ number_format($sale->total_arrears) }}</td>
        </tr>
    @endforeach
    @if($sales->isEmpty())
        <tr>
            <td colspan="8" style="text-align: center;">No sales found for selected month.</td>
        </tr>
    @endif
    </tbody>
</table>
</body>
</html>
