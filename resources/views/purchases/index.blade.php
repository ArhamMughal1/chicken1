<x-app-layout>
    <div class="content" x-data="purchases">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-primary-100 text-2xl font-bold">Supplier Ledger
                <bdi>(فراہم کنندوں کا کھاتہ)</bdi>
            </h1>
            <div>
                <x-input-label
                    for="selectedDate"
                    :value="__('Search by Date:')"
                    class="inline-block font-bold"
                />
                <x-text-input
                    id="selectedDate"
                    type="date"
                    @change="$event.target.value && (window.location.href = `?date=${selectedDate}`)"
                    x-model="selectedDate"
                />
            </div>
        </div>

        <ul dir="rtl">
            <li>
                <bdi><b>منڈی ریٹ</b></bdi>
                : {{$today_rate->mandi_rate ?? 0}}</li>
            <li>
                <bdi><b>سلیٹ ریٹ</b></bdi>
                : {{$today_rate->slate_rate ?? 0}}</li>
        </ul>

        <div class="bg-white rounded p-4 mt-4">
            <div class="relative">
                <table class="w-full font-nastaliq text-right" dir="rtl">
                    <thead>
                    <tr>
                        <th scope="col">نام فارمر</th>
                        <th scope="col">نام ڈرائیور</th>
                        <th scope="col">گاڑی نمبر</th>
                        <th scope="col">لوڈ ویٹ</th>
                        <th scope="col">نیٹ ویٹ</th>
                        <th scope="col">ویٹ شارٹ</th>
                        <th scope="col">لیس</th>
                        <th scope="col">قیمت</th>
                        <th scope="col">رقم</th>
                        <th scope="col">رقم گودام</th>
                        <th scope="col">ادا کردہ رقم</th>
                        <th scope="col" class="text-left">Actions</th>
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
                            <td>{{number_format($item->amount - ($item->net_weight * $item->rate))}}</td>
                            <td>{{number_format($item->paid)}}</td>
                            <td>
                                <div class="text-sm text-gray-700 dark:text-gray-200 flex justify-end gap-4">
                                    <a href="{{ route('purchase.edit', $item->id) }}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a href="{{ route('purchase.destroy', $item->id) }}"
                                       onclick="return confirm('Are you sure?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Total</th>
                        <td></td>
                        <td></td>
                        <td>{{number_format($totals['supp_load_weight'],2)}}</td>
                        <td>{{number_format($totals['supp_net_weight'],2)}}</td>
                        <td>{{number_format($totals['supp_short_weight'],2)}}</td>
                        <td></td>
                        <td></td>
                        <td>{{number_format($totals['supp_amount'],2)}}</td>
                        <td></td>
                        <td>{{number_format($totals['supp_paid'],2)}}</td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="bg-white rounded p-4 mt-4" dir="rtl">
            <h4 class="text-primary-100 text-xl font-bold mb-2">
                <bdi>وزن کی تفصیلات</bdi>
            </h4>
            <div class="relative overflow-x-auto">
                <table class="w-full text-right">
                    <tbody>
                    <tr>
                        <th scope="col">
                            <bdi>ٹوٹل ویٹ خرید</bdi>
                        </th>
                        <td>{{number_format($totals['supp_net_weight'],2)}}</td>
                    </tr>
                    <tr>
                        <th scope="col">
                            <bdi>ٹوٹل شارٹ ویٹ</bdi>
                        </th>
                        <td>{{number_format($totals['supp_short_weight'],2)}}</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>
                            <bdi>ٹوٹل ویٹ</bdi>
                        </th>
                        <td>{{number_format($totals['supp_net_weight'] +  $totals['supp_short_weight'],2)}}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="bg-white rounded p-4 mt-4" dir="rtl">
            <h4 class="text-primary-100 text-xl font-bold mb-2">
                <bdi>وزن کی تفصیلات</bdi>
            </h4>
            <div class="relative overflow-x-auto">
                <table class="w-full text-right">
                    <tbody>
                    <tr>
                        <th scope="col">
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
                        <td>{{number_format($totals['net_weight'] - ($totals['credit_weight_sale'] + $totals['cash_weight_sale'] +  $totals['short_weight']),2)}}</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>
                            <bdi>بقایا ویٹ</bdi>
                        </th>
                        <td>{{number_format($totals['short_weight'],2)}}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="mt-2 text-right">
            <a target="_blank" :href="`/supplier-ledger/report?date=${selectedDate}`" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Download Report</a>
        </div>
    </div>
</x-app-layout>
