<x-app-layout>
    <div class="content" x-data="clientSales">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-primary-100 text-2xl font-bold">Client Sales
                <bdi>(دکاندارون کاکھاتہ)</bdi>
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
            <div class="relative overflow-x-auto">
                <table class="w-full text-right" dir="rtl">
                    <thead class="font-nastaliq leading-nastaliq">
                    <tr>
                        <th scope="col">نام دکاندار</th>
                        <th scope="col">ریٹ</th>
                        <th scope="col">وزن</th>
                        <th scope="col">مال‌رقم</th>
                        <th scope="col">وصول‌رقم</th>
                        <th scope="col">بقایاجات</th>
                        <th scope="col">سابقہ بقایا</th>
                        <th scope="col">ٹوٹل‌بقایا</th>
                        <th scope="col">تفصیل</th>
                        <th scope="col" class="text-left">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($sales as $item)
                        <tr>
                            <td class="font-nastaliq leading-nastaliq">{{$item->client->full_name}}</td>
                            <td dir="ltr">{{$item->rate}}</td>
                            <td dir="ltr">{{$item->weight}}</td>
                            <td dir="ltr">{{number_format($item->amount)}}</td>
                            <td dir="ltr">{{number_format($item->amount_paid)}}</td>
                            <td dir="ltr">{{number_format($item->arrears)}}</td>
                            <td dir="ltr">{{number_format($item->previous_arrears)}}</td>
                            <td dir="ltr">{{number_format($item->total_arrears)}}</td>
                            <td dir="ltr">{{$item->description}}</td>
                            <td>
                                <div class="text-sm text-gray-700 dark:text-gray-200 flex justify-end gap-4">
                                    <a href="{{ route('sale.edit', $item->id) }}">
                                        <i class="fa-regular fa-pen-to-square text-green-600"></i>
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
                        <td dir="ltr">{{ number_format($totals['weight'], 2) }}</td>
                        <td dir="ltr">{{ number_format($totals['amount'], 2) }}</td>
                        <td dir="ltr">{{ number_format($totals['amount_paid']) }}</td>
                        <td dir="ltr">{{ number_format($totals['arrears']) }}</td>
                        <td dir="ltr">{{ number_format($totals['previous_arrears']) }}</td>
                        <td dir="ltr">{{ number_format($totals['total_arrears']) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
        <div class="mt-2 text-right">
            <a target="_blank" :href="`/client-ledger/report?date=${selectedDate}`" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Download Report</a>
        </div>
    </div>
</x-app-layout>
