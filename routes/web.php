<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ClientSaleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\WeightShortageController;
use App\Http\Controllers\SupplierPurchaseController;
use App\Http\Controllers\CashAccountController;
use App\Http\Controllers\GodownWeightController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ----------- Rate List ------------ //
    Route::get('/rate-list', [RateController::class, 'index'])->name('rate.index');
    Route::post('/rate/add', [RateController::class, 'store'])->name('rate.store');
    Route::get('/rate/edit/{id}', [RateController::class, 'edit'])->name('rate.edit');
    Route::put('/rate/edit/{id}', [RateController::class, 'update'])->name('rate.update');

    // ----------- Clients ------------ //
    Route::get('/clients', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client/add', [ClientController::class, 'create'])->name('client.create');
    Route::post('/client/add', [ClientController::class, 'store'])->name('client.store');
    Route::get('/client/edit/{id}', [ClientController::class, 'edit'])->name('client.edit');
    Route::put('/client/edit/{id}', [ClientController::class, 'update'])->name('client.update');
    Route::get('/client/delete/{id}', [ClientController::class, 'destroy'])->name('client.destroy');

    // ----------- Client Sales ------------ //
    Route::get('/client-ledger', [SaleController::class, 'index'])->name('sale.index');
    Route::get('/client-ledger/add', [SaleController::class, 'create'])->name('sale.create');
    Route::post('/client-ledger/add', [SaleController::class, 'store'])->name('sale.store');
    Route::get('/client-ledger/edit/{id}', [SaleController::class, 'edit'])->name('sale.edit');
    Route::put('/client-ledger/edit/{id}', [SaleController::class, 'update'])->name('sale.update');
    Route::get('/client-ledger/report', [SaleController::class, 'report'])->name('sale.report');

    Route::get('/client-ledger/batch/edit', [SaleController::class, 'batchEdit'])->name('sale.batch-edit')->defaults('date', now()->format('Y-m-d'));
    Route::put('/client-ledger/{date}', [SaleController::class, 'batchUpdate'])->name('sale.batch-update');

    Route::get('/clients/{client}/sales', [ClientSaleController::class, 'index'])
        ->name('clients.sales');
    Route::get('/clients/{client}/sales/report', [ClientSaleController::class, 'report'])->name('clients.sales.report');

    // ----------- Suppliers ------------ //
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/supplier/add', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/supplier/add', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier/edit/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::get('/supplier/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

    // ----------- Supplier Purchases ------------ //
    Route::get('/supplier-ledger', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/supplier-ledger/add', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/supplier-ledger/add', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/supplier-ledger/edit/{id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('/supplier-ledger/edit/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::get('/supplier-ledger/delete/{id}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');
    Route::get('/supplier-ledger/report', [PurchaseController::class, 'report'])->name('purchase.report');

    Route::get('/suppliers/{supplier}/purchases', [SupplierPurchaseController::class, 'index'])
        ->name('suppliers.purchases');
    Route::get('/suppliers/{supplier}/purchases/report', [SupplierPurchaseController::class, 'report'])->name('suppliers.purchases.report');

    Route::resource('expenses', ExpenseController::class);

        Route::resource('drivers', DriverController::class);

    Route::resource('weight-shortages', WeightShortageController::class);

    Route::resource('godown-weights', GodownWeightController::class);

    Route::resource('cash-accounts', CashAccountController::class);
    Route::get('/cash-accounts/report/{date}', [CashAccountController::class, 'report'])->name('cashAccount.report');


});

require __DIR__.'/auth.php';
