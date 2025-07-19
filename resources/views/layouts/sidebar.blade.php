<aside class="sidebar h-full bg-gray-200">
    <div class="sidebar-container overflow-y-auto h-full">
        <div class="menu-container">
            <ul class="w-full p-4 min-w-72 space-y-1">
                <li class="w-full">
                    <a href="/dashboard"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">Dashboard</span>
                        <i class="fa-solid fa-gauge"></i>
                    </a>
                </li>
                <li class="w-full">
                    <a href="/rate-list"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">Rate List</span>
                        <i class="fa-solid fa-list"></i>
                    </a>
                </li>

                {{-- Suppliers --}}
                <li class="w-full">
                    <a href="/suppliers"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">Suppliers</span>
                        <i class="fa-solid fa-truck"></i>
                    </a>
                </li>
                <li class="w-full">
                    <a href="/supplier-ledger"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">Suppliers Ledger</span>
                        <i class="fa-solid fa-truck"></i>
                    </a>
                </li>
                <li class="w-full pl-4">
                    <a href="/supplier-ledger/add"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">New Purchase Entry</span>
                        <i class="fa-solid fa-truck"></i>
                    </a>
                </li>

                {{-- Clients --}}
                <li class="w-full">
                    <a href="/clients"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">Clients</span>
                        <i class="fa-solid fa-users"></i>
                    </a>
                </li>
                <li class="w-full">
                    <a href="/client-ledger"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">Clients Ledger</span>
                        <i class="fa-solid fa-users"></i>
                    </a>
                </li>
                <li class="w-full pl-4">
                    <a href="/client-ledger/add"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">New Sale Entry</span>
                        <i class="fa-solid fa-users"></i>
                    </a>
                </li>
                <li class="w-full pl-4">
                    <a href="{{ route('sale.batch-edit') }}"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">Edit Sale Entry</span>
                        <i class="fa-solid fa-users"></i>
                    </a>
                </li>

                {{-- Expenses --}}
                <li class="w-full">
                    <a href="/expenses"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">{{ __('Expenses') }}</span>
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </a>
                </li>
                <li class="w-full pl-4">
                    <a href="{{ route('expenses.create') }}"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">New Expense Entry</span>
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </a>
                </li>

                <li class="w-full">
                    <a href="{{ route('drivers.index') }}"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">{{ __('Drivers') }}</span>
                        <i class="fa-solid fa-user-secret"></i>
                    </a>
                </li>
                <li class="w-full pl-4">
                    <a href="{{ route('drivers.create') }}"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">New Driver Entry</span>
                        <i class="fa-solid fa-user-secret"></i>
                    </a>
                </li>

                <li class="w-full">
                    <a href="{{ route('weight-shortages.index') }}"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">{{ __('Weight Shortages') }}</span>
                        <i class="fa-solid fa-scale-unbalanced"></i>
                    </a>
                </li>
                <li class="w-full pl-4">
                    <a href="{{ route('weight-shortages.create') }}"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">New Shortage Entry</span>
                        <i class="fa-solid fa-scale-unbalanced"></i>
                    </a>
                </li>
                <li class="w-full">
                    <a href="{{ route('godown-weights.index') }}"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">{{ __('Godown Weights') }}</span>
                        <i class="fa-solid fa-weight-scale"></i>
                    </a>
                </li>
                <li class="w-full pl-4">
                    <a href="{{ route('godown-weights.create') }}"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">Add Weight Record</span>
                        <i class="fa-solid fa-weight-scale"></i>
                    </a>
                </li>

                <li class="w-full">
                    <a href="{{ route('cash-accounts.index') }}"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">{{ __('Cash Account') }}</span>
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </a>
                </li>
                <li class="w-full pl-4">
                    <a href="{{ route('cash-accounts.create') }}"
                       class="w-full text-base font-medium flex items-center justify-between py-2 px-4 bg-gray-600 text-white rounded-md">
                        <span class="menu-items-text">Add Cash in Hand</span>
                        <i class="fa-solid fa-hand-holding-usd"></i>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</aside>
