<x-app-layout>
{{--    @section('title', 'Clients')--}}
    <div class="content">
        <div class="mb-3">
            <h1 class="text-primary-100 text-2xl font-bold">Clients <bdi>(دکاندار حضرات)</bdi></h1>
        </div>

        <div class="bg-white rounded p-4">
            <h4 class="text-lg font-bold mb-5">{{ isset($client) ? 'Edit' : 'Add' }} Client <bdi>(دکاندار کا اندراج کریں)</bdi></h4>
            <form action="{{ isset($client) ? route('client.update', $client->id) : route('client.store') }}"
                  method="POST">
                @csrf
                @if(isset($client))
                    @method('PUT')
                @endif
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <div class="mb-4">
                            <x-input-label for="full_name" :value="__('Full Name *')"/>
                            <x-text-input
                                id="full_name"
                                name="full_name"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('full_name',$client->full_name ?? '')"
                                required
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('full_name')"/>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="mobile" :value="__('Mobile')"/>
                            <x-text-input
                                id="mobile"
                                name="mobile"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('mobile',$client->mobile ?? '')"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('mobile')"/>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="discount" :value="__('Discount *')"/>
                            <x-text-input
                                id="discount"
                                name="discount"
                                type="number"
                                step="0.01"
                                class="mt-1 block w-full"
                                :value="old('discount',$client->discount ?? 0)"
                                required
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('discount')"/>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="balance" :value="__('Balance *')"/>
                            <x-text-input
                                id="balance"
                                name="balance"
                                type="number"
                                class="mt-1 block w-full"
                                :value="old('balance',$client->balance ?? 0)"
                                required
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('discount')"/>
                        </div>
                        <div>
                            <x-input-label for="category" :value="__('Category *')"/>
                            <select id="category" name="category" class="w-full mt-1 !leading-nastaliq"
                                    dir="ltr">
                                <option value="cash" @if(old('category', $client->category ?? '') == 'cash') selected @endif>Cash</option>
                                <option value="credit" @if(old('category', $client->category ?? '') == 'credit') selected @endif>Credit</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category')"/>
                        </div>
                    </div>
                    <div>
                        <div>
                            <x-input-label for="status" :value="__('Status')"/>
                            <label class="relative inline-flex items-center cursor-pointer mt-1">
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-300">inActive</span>
                                <input name="status" type="checkbox" value="1" @if(old('status', $client->status ?? 1) == 1) checked @endif class="sr-only peer">
                                <div class="w-14 h-7 mx-2 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300
                            dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full
                            rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                             after:top-[2px] after:bg-white after:border-gray-300 after:border
                             after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600
                             peer-checked:bg-blue-600 after:left-[66px]"></div>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Active</span>
                            </label>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="details" :value="__('Details')"/>
                            <textarea id="details"
                                      name="details"
                                      class="w-full mt-1"
                                      rows="4">{{old('details',$client->details ?? '')}}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('details')"/>
                        </div>
                    </div>
                </div>



                <div class="text-right mt-4">
                    <x-primary-button type="submit">{{ isset($client) ? 'Update' : 'Add' }}</x-primary-button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded p-4 mt-4">
            <div class="relative overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Balance</th>
                        <th scope="col">Category</th>
                        <th scope="col">Status</th>
                        <th scope="col">Details</th>
                        <th scope="col" class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($clients as $item)
                        <tr>
                            <td>{{$item->full_name}}</td>
                            <td>{{$item->mobile}}</td>
                            <td>{{$item->discount}}</td>
                            <td>{{$item->balance}}</td>
                            <td>{{$item->category}}</td>
                            <td>
                                @if ($item->status == '1')
                                    <span
                                        class="py-px px-2 text-sm text-green-950 rounded-lg bg-green-100"
                                        role="alert">Active</span>
                                @else
                                    <span
                                        class="py-px px-2 text-sm text-red-950 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-blue-400"
                                        role="alert">InActive</span>
                                @endif
                            </td>
                            <td>{{$item->details}}</td>
                            <td>
                                <div class="text-sm text-gray-700 dark:text-gray-200 flex justify-end gap-4">
                                    <a href="{{ route('clients.sales', $item->id) }}" class="text-blue-600 hover:text-blue-900">
                                        View Sales
                                    </a>
                                    <a href="{{ route('client.edit', $item->id) }}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a href="{{ route('client.destroy', $item->id) }}"
                                       onclick="return confirm('Are you sure?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
