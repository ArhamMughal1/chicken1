<x-app-layout>
    <div class="content" x-data="{
        selectedMonth: new URLSearchParams(window.location.search).get('month') || new Date().toISOString().slice(0, 7),
        mandi_rate: {{ old('mandi_rate', $rate->mandi_rate ?? 0) }},
        slate_rate: {{ old('slate_rate', $rate->slate_rate ?? 0) }},
        calculateSlateRate() {
            if (this.mandi_rate) {
                this.slate_rate = Math.round(this.mandi_rate / 40) + 10;
            } else {
                this.slate_rate = 0;
            }
        }
    }">
        <div class="mb-3">
            <h1 class="text-primary-100 text-2xl font-bold">Rate List <bdi>(ریٹ لسٹ)</bdi></h1>
        </div>

        <div class="bg-white rounded p-4">
            <h4 class="text-lg font-bold mb-5">{{ isset($rate) ? 'Edit' : 'Add' }} Rate <bdi>(ریٹ کا اندراج کریں)</bdi></h4>
            <form action="{{ isset($rate) ? route('rate.update', $rate->id) : route('rate.store') }}"
                  method="POST">
                @csrf
                @if(isset($rate))
                    @method('PUT')
                @endif
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="price_date" :value="__('Date *')"/>
                        <x-text-input
                            id="price_date"
                            name="price_date"
                            type="date"
                            class="mt-1 block w-full"
                            :value="old('price_date',$rate->price_date ?? '')"
                            required
                            :readonly="isset($rate)"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('price_date')"/>
                    </div>
                    <div>
                        <x-input-label for="mandi_rate" :value="__('Mandi Rate *')"/>
                        <x-text-input
                            id="mandi_rate"
                            name="mandi_rate"
                            type="number"
                            min="0"
                            class="mt-1 block w-full"
                            x-model.number="mandi_rate"
                            @input="calculateSlateRate()"
                            :value="old('mandi_rate',$rate->mandi_rate ?? '')"
                            required
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('mandi_rate')"/>
                    </div>
                    <div>
                        <x-input-label for="slate_rate" :value="__('Slate Rate *')"/>
                        <x-text-input
                            id="slate_rate"
                            name="slate_rate"
                            type="number"
                            min="0"
                            class="mt-1 block w-full"
                            x-model.number="slate_rate"
                            :value="old('slate_rate',$rate->slate_rate ?? '')"
                            required
                            readonly
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('slate_rate')"/>
                    </div>
                </div>

                <div class="text-right mt-4">
                    <x-primary-button type="submit">{{ isset($rate) ? 'Update' : 'Add' }}</x-primary-button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded p-4 mt-4">
            <div class="flex justify-end mb-4">
                <div>
                    <x-input-label
                        for="month"
                        :value="__('Search by Month:')"
                        class="inline-block font-bold"
                    />
                    <x-text-input
                        id="month"
                        name="month"
                        type="month"
                        @change="$event.target.value && (window.location.href = `?month=${selectedMonth}`)"
                        x-model="selectedMonth"
                    />
                </div>
            </div>

            <div class="relative overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Mandi Rate</th>
                        <th scope="col">Slate Rate</th>
                        <th scope="col" class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($rates as $rate)
                        <tr>
                            <td>{{\Carbon\Carbon::parse($rate->price_date)->format('d/m/Y')}}</td>
                            <td>{{$rate->mandi_rate}}</td>
                            <td>{{$rate->slate_rate}}</td>
                            <td class="text-right">
                                @if(\Carbon\Carbon::parse($rate->price_date)->isToday())
                                    <a href="{{ route('rate.edit', $rate->id) }}" class="text-sm text-gray-700 dark:text-gray-200">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
