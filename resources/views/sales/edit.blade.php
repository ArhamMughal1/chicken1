<x-app-layout>
    <div class="content"
         x-data="saleEdit(
             {{ $today_rate->slate_rate ?? 0 }},
             {{ $sale->rate_difference ?? 0 }},
             {{ $sale->rate ?? 0 }},
             {{ $sale->weight ?? 0 }},
             {{ $sale->amount ?? 0 }},
             {{ $sale->amount_paid ?? 0 }},
             {{ $sale->arrears ?? 0 }},
             {{ $sale->previous_arrears ?? 0 }},
             {{ $sale->total_arrears ?? 0 }}
         )"
    >
        <div class="mb-3">
            <h1 class="text-primary-100 text-2xl font-bold">Client Ledger
                <bdi>(دکاندارون کاکھاتہ)</bdi>
            </h1>
            @if(!isset($today_rate))
                <div
                    class="text-right text-sm bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded relative mt-2"
                    role="alert">
                    <bdi class="block sm:inline">برائے مہربانی آج کے ریٹس کا اندراج کر لیں۔</bdi>
                    <strong class="font-bold">: Warning!</strong>
                </div>
            @endif
        </div>

        <div class="bg-white rounded p-4">
            <h4 class="text-lg font-bold mb-5">Edit Sale
                <bdi>(سیل کا اندراج کریں)</bdi>
            </h4>
            <form action="{{ route('sale.update', $sale->id) }}"
                  method="POST" dir="rtl">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mt-2">
                    <div>
                        <x-input-label class="leading-nastaliq font-nastaliq" for="sale_date" :value="__('تاریخ')"/>
                        <x-text-input
                            id="sale_date"
                            name="sale_date"
                            type="date"
                            class="mt-1 block w-full font-nastaliq !leading-nastaliq"
                            :value="$sale->sale_date->toDateString() ?? \Carbon\Carbon::now()->toDateString()"
                            required
                            readonly
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('sale_date')"/>
                    </div>
                    <div>
                        <x-input-label class="leading-nastaliq font-nastaliq" for="name" :value="__('نام دکاندار')"/>
                        <input type="hidden" name="client_id" value="{{$sale->client_id}}">
                        <x-text-input
                            type="text"
                            class="mt-1 block w-full font-nastaliq !leading-nastaliq"
                            :value="$sale->client->full_name"
                            readonly
                        />

                    </div>
                    <div>
                        <x-input-label class="leading-nastaliq font-nastaliq" for="rate_difference" :value="__('لیس')"/>
                        <x-text-input
                            dir="ltr"
                            name="rate_difference"
                            type="number"
                            step="0.01"
                            class="mt-1 block w-full text-right !leading-nastaliq"
                            x-model="rateDifference"
                            @input="updateCalculations"
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('rate_difference')"/>
                    </div>
                    <div>
                        <x-input-label class="leading-nastaliq font-nastaliq" for="rate" :value="__('ریٹ')"/>
                        <x-text-input
                            dir="ltr"
                            name="rate"
                            type="number"
                            step="0.01"
                            class="mt-1 block w-full text-right !leading-nastaliq"
                            x-model="rate"
                            readonly
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('rate')"/>
                    </div>
                    <div>
                        <x-input-label class="leading-nastaliq font-nastaliq" for="weight" :value="__('وزن')"/>
                        <x-text-input
                            dir="ltr"
                            name="weight"
                            type="number"
                            step="0.01"
                            class="mt-1 block w-full text-right !leading-nastaliq"
                            x-model="weight"
                            @input="updateCalculations"
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('weight')"/>
                    </div>
                    <div>
                        <x-input-label class="leading-nastaliq font-nastaliq" for="amount" :value="__('مال‌رقم')"/>
                        <x-text-input
                            dir="ltr"
                            name="amount"
                            type="number"
                            step="0.01"
                            class="mt-1 block w-full text-right !leading-nastaliq"
                            x-model="amount"
                            readonly
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('amount')"/>
                    </div>
                    <div>
                        <x-input-label class="leading-nastaliq font-nastaliq" for="amount_paid" :value="__('وصول‌رقم')"/>
                        <x-text-input
                            dir="ltr"
                            name="amount_paid"
                            type="number"
                            class="mt-1 block w-full text-right !leading-nastaliq"
                            x-model="amountPaid"
                            @input="updateCalculations"
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('amount_paid')"/>
                    </div>
                    <div>
                        <x-input-label class="leading-nastaliq font-nastaliq" for="arrears" :value="__('بقایاجات')"/>
                        <x-text-input
                            dir="ltr"
                            name="arrears"
                            type="number"
                            class="mt-1 block w-full text-right !leading-nastaliq"
                            x-model="arrears"
                            readonly
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('arrears')"/>
                    </div>
                    <div>
                        <x-input-label class="leading-nastaliq font-nastaliq" for="previous_arrears"
                                       :value="__('سابقہ بقایا')"/>
                        <x-text-input
                            dir="ltr"
                            name="previous_arrears"
                            type="number"
                            class="mt-1 block w-full text-right !leading-nastaliq"
                            x-model="previousArrears"
                            readonly
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('previous_arrears')"/>
                    </div>
                    <div>
                        <x-input-label class="leading-nastaliq font-nastaliq" for="total_arrears"
                                       :value="__('ٹوٹل‌بقایا')"/>
                        <x-text-input
                            dir="ltr"
                            name="total_arrears"
                            type="number"
                            class="mt-1 block w-full text-right !leading-nastaliq"
                            x-model="totalArrears"
                            readonly
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('total_arrears')"/>
                    </div>
                </div>
                <div class="text-right mt-4">
                    <x-primary-button type="submit">Update</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
