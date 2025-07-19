<x-app-layout>
    <div class="content"
         x-data="purchaseEntry({{ $today_rate->slate_rate ?? 0 }}, {{ old('load_weight', $purchase->load_weight ?? 0) }}, {{ old('net_weight', $purchase->net_weight ?? 0) }})"
    >
        <div class="mb-3">
            <h1 class="text-primary-100 text-2xl font-bold">Supplier Ledger
                <bdi>(فراہم کنندوں کا کھاتہ)</bdi>
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
            <h4 class="text-lg font-bold mb-5">{{ isset($purchase) ? 'Edit' : 'Add' }} Purchase
                <bdi>(خرید کا اندراج کریں)</bdi>
            </h4>
            <form action="{{ isset($purchase) ? route('purchase.update', $purchase->id) : route('purchase.store') }}"
                  method="POST" dir="rtl">
                @csrf
                @if(isset($purchase))
                    @method('PUT')
                @endif



                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <x-input-label class="leading-nastaliq font-nastaliq" for="purchase_date" :value="__('تاریخ *')"/>
                        <x-text-input
                            id="purchase_date"
                            name="purchase_date"
                            type="date"
                            class="mt-1 block w-full"
                            :value="old('purchase_date',$purchase->purchase_date ?? \Carbon\Carbon::now()->toDateString())"
                            @change="updateUrl"
                            x-model="selectedDate"
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('purchase_date')"/>
                    </div>
                    <div>
                        <x-input-label class="font-nastaliq leading-nastaliq" for="supplier_id" :value="__('نام فارمر *')"/>
                        <select id="supplier_id" name="supplier_id" class="w-full mt-1"
                                x-model="selectedSupplier"
{{--                                @change="updateUrl"--}}
                                dir="ltr">
                            @foreach($suppliers as $item)
                                <option value="{{ $item->id }}"
                                        data-discount="{{ $item->discount }}"
                                        @if(old('supplier_id', $purchase->supplier_id ?? '') == $item->id) selected @endif>{{ $item->full_name }}</option>
                            @endforeach
                        </select>
                    </div>



                    <div>
                        <x-input-label class="font-nastaliq leading-nastaliq" for="driver_name" :value="__('نام ڈرائیور')"/>
                        <x-text-input
                            id="driver_name"
                            name="driver_name"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('driver_name',$purchase->driver_name ?? '')"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('driver_name')"/>
                    </div>

                    <div>
                        <x-input-label class="font-nastaliq leading-nastaliq" for="vehicle_number" :value="__('گاڑی نمبر')"/>
                        <x-text-input
                            id="vehicle_number"
                            name="vehicle_number"
                            type="text"
                            class="mt-1 block w-full text-right"
                            :value="old('vehicle_number',$purchase->vehicle_number ?? '')"
                            dir="ltr"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('vehicle_number')"/>
                    </div>


                    <div>
                        <x-input-label class="font-nastaliq leading-nastaliq" for="load_weight" :value="__('لوڈ ویٹ *')"/>
                        <x-text-input
                            id="load_weight"
                            name="load_weight"
                            type="number"
                            class="mt-1 block w-full text-right"
                            :value="old('load_weight',$purchase->load_weight ?? '')"
                            @input="updateCalculations"
                            x-model="loadWeight"
                            step="0.1"
                            required
                            dir="ltr"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('load_weight')"/>
                    </div>


                    <div>
                        <x-input-label class="font-nastaliq leading-nastaliq" for="net_weight" :value="__('نیٹ ویٹ *')"/>
                        <x-text-input
                            id="net_weight"
                            name="net_weight"
                            type="number"
                            class="mt-1 block w-full text-right"
                            :value="old('net_weight',$purchase->net_weight ?? '')"
                            @input="updateCalculations"
                            x-model="netWeight"
                            step="0.1"
                            required
                            dir="ltr"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('net_weight')"/>
                    </div>

                    <div>
                        <x-input-label class="font-nastaliq leading-nastaliq" for="short_weight" :value="__('شارٹ ویٹ')"/>
                        <x-text-input
                            id="short_weight"
                            name="short_weight"
                            type="number"
                            class="mt-1 block w-full text-right bg-gray-100"
                            :value="old('short_weight',$purchase->short_weight ?? 0)"
                            x-model="shortWeight"
                            readonly
                            dir="ltr"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('short_weight')"/>
                    </div>

                    <div>
                        <x-input-label class="font-nastaliq leading-nastaliq" for="rate_difference" :value="__('لیس')"/>
                        <x-text-input
                            id="rate_difference"
                            name="rate_difference"
                            type="number"
                            step="0.0001"
                            class="mt-1 block w-full text-right"
                            :value="old('rate_difference',$purchase->rate_difference ?? '')"
                            @input="updateCalculations"
                            x-model="rateDifference"
                            dir="ltr"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('rate_difference')"/>
                    </div>
                    <div>
                        <x-input-label class="font-nastaliq leading-nastaliq" for="rate" :value="__('ریٹ')"/>
                        <x-text-input
                            id="rate"
                            name="rate"
                            type="number"
                            step="0.01"
                            class="mt-1 block w-full text-right"
                            value="{{ $today_rate->slate_rate }}"
                            x-model="rate"
                            readonly
                            dir="ltr"
                        />
                    </div>
                    <div>
                        <x-input-label class="font-nastaliq leading-nastaliq" for="amount" :value="__('‌رقم')"/>
                        <x-text-input
                            id="amount"
                            name="amount"
                            type="number"
                            class="mt-1 block w-full text-right"
                            :value="old('amount',$purchase->amount ?? '')"
                            x-model="amount"
                            readonly
                            dir="ltr"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('amount')"/>
                    </div>
                </div>
                @if(isset($purchase))
                    <div class="mx-2">
                        <div>
                            <x-input-label class="font-nastaliq leading-nastaliq" for="paid" :value="__('ادا کردہ رقم')"/>
                            <x-text-input
                                id="paid"
                                name="paid"
                                type="number"
                                class="mt-1 block w-full text-right"
                                :value="old('paid',$purchase->paid ?? 0)"
                                x-model="paid"
                                dir="ltr"
                                value="{{ $purchase->paid }}"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('paid')"/>
                        </div>
                    </div>
                @endif
                @if(isset($purchase))
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mt-4">
                        <x-input-label class="font-nastaliq leading-nastaliq" for="textarea" :value="__('‌تفصیل')"/>
                        <textarea rows="4" name="description">{{ $purchase->description }}</textarea>
                    </div>
                @endif
                <div class="text-right mt-4">
                    <x-primary-button type="submit">{{ isset($purchase) ? 'Update' : 'Add' }}</x-primary-button>
                </div>
            </form>
            <script>
                const defaultRate = document.getElementById('rate').value;
                document.getElementById('supplier_id').addEventListener('change', function () {
                    const rateInput = document.getElementById('rate');
                    if (this.value === '9') {
                        rateInput.removeAttribute('readonly');
                    } else {
                        rateInput.setAttribute('readonly', true);
                        rateInput.value = parseFloat(defaultRate)
                    }
                });
            </script>
        </div>
    </div>
</x-app-layout>
