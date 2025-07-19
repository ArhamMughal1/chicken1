<x-app-layout>
    <div class="content" x-data="saleEntry">
        <div class="mb-3">
            <h1 class="text-primary-100 text-2xl font-bold">Client Ledger
                <bdi>(دکاندارون کاکھاتہ)</bdi>
            </h1>
            @if(!isset($today_rate))
                <div class="text-right text-sm bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded relative mt-2"
                    role="alert">
                    <bdi class="block sm:inline">برائے مہربانی آج کے ریٹس کا اندراج کر لیں۔</bdi>
                    <strong class="font-bold">: Warning!</strong>
                </div>
            @endif
        </div>

        <div class="bg-white rounded p-4">
            <!-- Category Filter Dropdown -->
            <div class="mb-4 flex justify-between items-center">
                <h4 class="text-lg font-bold">Add Sale
                    <bdi>(سیل کا اندراج کریں)</bdi>
                </h4>

                <div class="flex items-center">
                    <x-input-label for="category_filter" :value="__('Filter by Category')" class="mr-2" />
                    <select id="category_filter" x-model="selectedCategory" @change="filterClients"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-4 bg-gray-100 p-4 rounded-md">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white p-3 rounded shadow">
                        <h3 class="font-bold text-gray-700">Total Purchased</h3>
                        <p class="text-xl" x-text="purchaseWeight + ' kg'"></p>
                    </div>
                    <div class="bg-white p-3 rounded shadow">
                        <h3 class="font-bold text-gray-700">Short</h3>
                        <p class="text-xl" x-text="weightShortage + ' kg'"></p>
                    </div>
                    <div class="bg-white p-3 rounded shadow">
                        <h3 class="font-bold text-gray-700">Sold</h3>
                        <p class="text-sm">
                            Cash: <span x-text="cashSales + ' kg'"></span><br>
                            Credit: <span x-text="creditSales + ' kg'"></span>
                        </p>
                    </div>
                    <div class="bg-white p-3 rounded shadow">
                        <h3 class="font-bold text-gray-700">Remaining</h3>
                        <p class="text-xl" x-text="remainingWeight + ' kg'"></p>
                    </div>
                </div>
            </div>

            <form action="{{route('sale.store')}}" method="POST" dir="rtl">
                @csrf
                <div class="mb-4">
                    <x-input-label class="inline-block font-nastaliq" for="sale_date" :value="__('تاریخ')" />
                    <x-text-input id="sale_date" name="sale_date" type="date" class="mr-1"
                        :value="\Carbon\Carbon::now()->toDateString()" @change="updateUrl" x-model="selectedDate"
                        required />
                    <x-input-error class="mt-2" :messages="$errors->get('sale_date')" />
                </div>

                <div class="grid grid-cols-1 gap-1 md:grid-cols-9 font-nastaliq">
                    <x-input-label for="name" :value="__('نام دکاندار')" />
                    <x-input-label for="weight" :value="__('وزن')" />
                    <x-input-label for="amount" :value="__('مال‌رقم')" />
                    <x-input-label for="amount_paid" :value="__('وصول‌رقم')" />
                    <x-input-label for="arrears" :value="__('بقایاجات')" />
                    <x-input-label for="previous_arrears" :value="__('سابقہ بقایا')" />
                    <x-input-label for="total_arrears" :value="__('ٹوٹل‌بقایا')" />
                    <x-input-label for="description" :value="__('تفصیل')" />
                </div>

                <template x-for="(client, index) in filteredClients" :key="client.id">
                    <div class="grid grid-cols-1 gap-1 md:grid-cols-9 mt-2"
                        x-data="clientRow(client, {{ $today_rate->slate_rate ?? 0 }})">
                        <div>
                            <input type="hidden" x-bind:name="'clients[' + index + '][client_id]'"
                                x-bind:value="client.id">
                            <x-text-input type="text" class="mt-1 block w-full font-nastaliq !leading-nastaliq"
                                x-bind:value="client.full_name" readonly />
                            <input type="hidden" x-bind:value="client.category" x-text="client.category">
                        </div>
                        <div>
                            <x-text-input dir="ltr" x-bind:name="'clients[' + index + '][weight]'" type="number"
                                step="0.001" class="mt-1 block w-full text-right !leading-nastaliq" x-model="weight"
                                @input="updateCalculations" required />
                        </div>
                        <div>
                            <x-text-input dir="ltr" x-bind:name="'clients[' + index + '][amount]'" type="number"
                                step="0.01" class="mt-1 block w-full text-right !leading-nastaliq" x-model="amount"
                                readonly />
                        </div>
                        <div>
                            <x-text-input dir="ltr" x-bind:name="'clients[' + index + '][amount_paid]'" type="number"
                                class="mt-1 block w-full text-right !leading-nastaliq" x-model="amountPaid"
                                @input="updateCalculations" required />
                        </div>
                        <div>
                            <x-text-input dir="ltr" x-bind:name="'clients[' + index + '][arrears]'" type="number"
                                class="mt-1 block w-full text-right !leading-nastaliq" x-model="arrears" readonly />
                        </div>
                        <div>
                            <x-text-input dir="ltr" x-bind:name="'clients[' + index + '][previous_arrears]'"
                                type="number" class="mt-1 block w-full text-right !leading-nastaliq"
                                x-model="previousArrears" readonly />
                        </div>
                        <div>
                            <x-text-input dir="ltr" x-bind:name="'clients[' + index + '][total_arrears]'" type="number"
                                class="mt-1 block w-full text-right !leading-nastaliq" x-model="totalArrears"
                                readonly />
                        </div>
                        <div>
                            <x-text-input dir="ltr" x-bind:name="'clients[' + index + '][description]'" type="text"
                                class="mt-1 block w-full text-right !leading-nastaliq"  x-model="description" />
                        </div>
                    </div>
                </template>
                {{-- Custom Work Here --}}

                <div class="grid grid-cols-1 gap-1 md:grid-cols-9 mt-2"
                    x-data="clientRow(client, {{ $today_rate->slate_rate ?? 0 }})">
                    <div>
                        <x-text-input value="Total" type="text"
                            class="mt-1 block w-full font-nastaliq !leading-nastaliq" readonly />
                    </div>
                    <div>
                        <x-text-input dir="ltr" type="number" step="0.01" id="firstTotal"
                            class="mt-1 block w-full text-right !leading-nastaliq" readonly />
                    </div>
                    <div>
                        <x-text-input dir="ltr" type="number" step="0.01" id="secondTotal"
                            class="mt-1 block w-full text-right !leading-nastaliq" readonly />
                    </div>
                    <div>
                        <x-text-input dir="ltr" type="number" id="thirdTotal"
                            class="mt-1 block w-full text-right !leading-nastaliq" readonly />
                    </div>
                    <div>
                        <x-text-input dir="ltr" type="number" id="fourthTotal"
                            class="mt-1 block w-full text-right !leading-nastaliq" readonly />
                    </div>
                    <div>
                        <x-text-input dir="ltr" type="number" id="fifthTotal"
                            class="mt-1 block w-full text-right !leading-nastaliq" readonly />
                    </div>
                    <div>
                        <x-text-input dir="ltr" type="number" id="sixthTotal"
                            class="mt-1 block w-full text-right !leading-nastaliq" readonly />
                    </div>
                </div>


                <div class="text-right mt-4">
                    <x-primary-button type="submit">Submit</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script type="application/json" id="clients-data">
        {!! $clientsJson !!}
    </script>
    <script>
        function calculateSecondDivSum(myIndex) {
            let total = 0;

            // Get all containers
            const containers = document.querySelectorAll('.grid.grid-cols-1.gap-1.md\\:grid-cols-9.mt-2');

            containers.forEach((container, index) => {
                // Skip the last container
                if (index === containers.length - 1) return;

                const divs = container.querySelectorAll(':scope > div');

                if (divs.length >= myIndex) {
                    const input = divs[myIndex - 1].querySelector('input');
                    if (input && input.value) {
                        total += parseFloat(input.value) || 0;
                    }
                }
            });

            return parseFloat(total.toFixed(2));
        }
        document.addEventListener('input', function () {
            document.getElementById('firstTotal').value = calculateSecondDivSum(2);
            document.getElementById('secondTotal').value = calculateSecondDivSum(3);
            document.getElementById('thirdTotal').value = calculateSecondDivSum(4);
            document.getElementById('fourthTotal').value = calculateSecondDivSum(5);
            document.getElementById('fifthTotal').value = calculateSecondDivSum(6);
            document.getElementById('sixthTotal').value = calculateSecondDivSum(7);
        });
    </script>
</x-app-layout>