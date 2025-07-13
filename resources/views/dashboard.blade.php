<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if(!isset($today_rate))
        <div
            class="text-right text-sm bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded relative mb-2"
            role="alert">
            <bdi class="block sm:inline">برائے مہربانی آج کے ریٹس کا اندراج کر لیں۔</bdi>
            <strong class="font-bold">: Warning!</strong>
        </div>
    @endif
    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
        @if($today_rate)
            <div class="flex flex-col bg-white rounded-xl p-4 text-center">
                <h4 class="text-2xl text-black font-bold mb-3">Today Mandi Rate</h4>
                <div class="font-bold text-6xl">
                    {{$today_rate->mandi_rate}}
                </div>
            </div>


            <div class="flex flex-col bg-white rounded-xl p-4 text-center">
                <h4 class="text-2xl text-black font-bold mb-3">Today Slate Rate</h4>
                <div class="font-bold text-6xl">
                    {{$today_rate->slate_rate}}
                </div>
            </div>
        @endif

        <div class="flex flex-col bg-white rounded-xl p-4 text-center">
            <h4 class="text-2xl text-black font-bold mb-3">Today Weight Purchase</h4>
            <div class="font-bold text-6xl">
                {{$today_weight_purchase}}
            </div>
        </div>

        <div class="flex flex-col bg-white rounded-xl p-4 text-center">
            <h4 class="text-2xl text-black font-bold mb-3">Today Weight Sale</h4>
            <div class="font-bold text-6xl">
                {{$today_weight_sale}}
            </div>
        </div>

        <div class="flex flex-col bg-white rounded-xl p-4 text-center">
            <h4 class="text-2xl text-black font-bold mb-3">Today Remaining Weight</h4>
            <div class="font-bold text-6xl">
                {{$today_remaining_weight}}
            </div>
        </div>
    </div>
</x-app-layout>
