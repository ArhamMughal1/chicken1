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
        <h1 style="font-weight: bold">Supplier Ledger
            <span>(فراہم کنندوں کا کھاتہ)</span>
        </h1>
        <div>
            <span><b>Today Date:</b> {{ $currentDate->format('l, F j, Y') }}</span>
        </div>

        <ul dir="rtl" style="list-style: none; margin:0 0 20px; padding: 0;">
            <li>
                <bdi><b>منڈی ریٹ</b></bdi>
                : {{$today_rate->mandi_rate ?? 0}}</li>
            <li>
                <bdi><b>سلیٹ ریٹ</b></bdi>
                : {{$today_rate->slate_rate ?? 0}}</li>
        </ul>

        <table dir="rtl">
            <thead>
            <tr>
                <th>نام فارمر</th>
                <th>نام ڈرائیور</th>
                <th>گاڑی نمبر</th>
                <th>لوڈ ویٹ</th>
                <th>نیٹ ویٹ</th>
                <th>ویٹ شارٹ</th>
                <th>لیس</th>
                <th>قیمت</th>
                <th>رقم</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($purchases as $item)
                <tr>
                    <td>{{$item->supplier->full_name}}</td>
                    <td>{{$item->driver_name}}</td>
                    <td>{{$item->vehicle_number}}</td>
                    <td>{{$item->load_weight}}</td>
                    <td>{{$item->net_weight}}</td>
                    <td>{{$item->short_weight}}</td>
                    <td>{{$item->rate_difference}}</td>
                    <td>{{$item->rate}}</td>
                    <td>{{number_format($item->amount)}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>Total</th>
                <td></td>
                <td></td>
                <td>{{number_format($totals['load_weight'],2)}}</td>
                <td>{{number_format($totals['net_weight'],2)}}</td>
                <td>{{number_format($totals['short_weight'],2)}}</td>
                <td></td>
                <td></td>
                <td>{{number_format($totals['amount'],2)}}</td>
            </tr>
            </tfoot>
        </table>

        <div dir="rtl">
            <h4>
                <bdi>وزن کی تفصیلات</bdi>
            </h4>
            <div>
                <table style="text-align: right; width: 100%">
                    <tbody>
                    <tr>
                        <th style="width: 40%">
                            <bdi>ٹوٹل ویٹ خرید</bdi>
                        </th>
                        <td>{{number_format($totals['net_weight'],2)}}</td>
                    </tr>
                    <tr>
                        <th scope="col">
                            <bdi>کریڈیٹ پر ویٹ سیل</bdi>
                        </th>
                        <td>{{number_format($totals['credit_weight_sale'],2)}}</td>
                    </tr>
                    <tr>
                        <th scope="col">
                            <bdi>کیش پر ویٹ سیل</bdi>
                        </th>
                        <td>{{number_format($totals['cash_weight_sale'],2)}}</td>
                    </tr>
                    <tr>
                        <th scope="col">
                            <bdi>ٹوٹل شارٹ ویٹ</bdi>
                        </th>
                        <td>{{number_format($totals['short_weight'],2)}}</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>
                            <bdi>ٹوٹل ویٹ</bdi>
                        </th>
                        <td>{{number_format($totals['credit_weight_sale'] + $totals['cash_weight_sale'] +  $totals['short_weight'],2)}}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

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
            @foreach ($salesClient as $item)
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
                <td dir="ltr">{{ number_format($totals['weight_client'], 2) }}</td>
                <td dir="ltr">{{ number_format($totals['amount_client'], 2) }}</td>
                <td dir="ltr">{{ number_format($totals['amount_paid_client']) }}</td>
                <td dir="ltr">{{ number_format($totals['arrears_client']) }}</td>
                <td dir="ltr">{{ number_format($totals['previous_arrears_client']) }}</td>
                <td dir="ltr">{{ number_format($totals['total_arrears_client']) }}</td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
