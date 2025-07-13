<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Client Ledger Daily Report</title>
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
            border-collapse: collapse; /* Essential for proper borders */
            margin: 10px 0;
            font-family: 'Jameel Noori Nastaleeq', sans-serif;
            direction: rtl;
        }

        /* Cell borders */
        th, td {
            border: 1px solid #777777; /* Solid black border */
            padding: 8px;
            text-align: right; /* Right align for RTL */
        }

        /* Header styling */
        th {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div>
        <h1 style="font-weight: bold">Client Sales
            <span>(دکاندارون کاکھاتہ)</span>
        </h1>
        <div>
            <span><b>Report Date:</b> {{ $currentDate->format('l, F j, Y') }}</span>
        </div>

        <ul dir="rtl" style="list-style: none; text-align: right; margin: 0 0 20px; padding: 0">
            <li>
                <bdi><b>منڈی ریٹ</b></bdi>
                : {{$today_rate->mandi_rate ?? 0}}</li>
            <li>
                <bdi><b>سلیٹ ریٹ</b></bdi>
                : {{$today_rate->slate_rate ?? 0}}</li>
        </ul>

        <table dir="rtl" style="text-align: right; width: 100%">
            <thead>
            <tr>
                <th style="text-align: right">نام دکاندار</th>
                <th>لیس</th>
                <th>ریٹ</th>
                <th>وزن</th>
                <th>مال‌رقم</th>
                <th>وصول‌رقم</th>
                <th>بقایاجات</th>
                <th>سابقہ بقایا</th>
                <th>ٹوٹل‌بقایا</th>
                <th>کیش/کریڈٹ</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($sales as $item)
                <tr>
                    <td>{{$item->client->full_name}}</td>
                    <td dir="ltr">{{$item->rate_difference}}</td>
                    <td dir="ltr">{{$item->rate}}</td>
                    <td dir="ltr">{{$item->weight}}</td>
                    <td dir="ltr">{{number_format($item->amount)}}</td>
                    <td dir="ltr">{{number_format($item->amount_paid)}}</td>
                    <td dir="ltr">{{number_format($item->arrears)}}</td>
                    <td dir="ltr">{{number_format($item->previous_arrears)}}</td>
                    <td dir="ltr">{{number_format($item->total_arrears)}}</td>
                    <td dir="ltr">{{$item->sale_type}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th style="text-align: right">Total</th>
                <td></td>
                <td></td>
                <td dir="ltr">{{ number_format($totals['weight'], 2) }}</td>
                <td dir="ltr">{{ number_format($totals['amount'], 2) }}</td>
                <td dir="ltr">{{ number_format($totals['amount_paid']) }}</td>
                <td dir="ltr">{{ number_format($totals['arrears']) }}</td>
                <td dir="ltr">{{ number_format($totals['previous_arrears']) }}</td>
                <td dir="ltr">{{ number_format($totals['total_arrears']) }}</td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
