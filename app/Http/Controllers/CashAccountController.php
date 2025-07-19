<?php

namespace App\Http\Controllers;

use App\Models\{
    CashAccount,
    Purchase,
    Sale,
    Expense
};
use Illuminate\Http\Request;
use misterspelik\LaravelPdf\Facades\Pdf;
use Carbon\Carbon;

class CashAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cashAccounts = CashAccount::latest()->paginate(10);
        return view('cash-accounts.index', compact('cashAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cash-accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'details' => 'nullable|string',
        ]);

        CashAccount::create($validated);

        return redirect()->route('cash-accounts.index')
            ->with('success', 'Cash account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CashAccount $cashAccount)
    {
        $purchase = Purchase::where('purchase_date', $cashAccount->date)->sum('amount');
        $purchasePaid = Purchase::where('purchase_date', $cashAccount->date)->sum('paid');
        $sales = Sale::where('sale_date', $cashAccount->date)->sum('total_arrears');
        $salesPaid = Sale::where('sale_date', $cashAccount->date)->sum('amount_paid');
        $expense = Expense::where('date', $cashAccount->date)->sum('amount');
        return view('cash-accounts.show', compact('cashAccount', 'purchase', 'purchasePaid', 'sales', 'salesPaid', 'expense'));
    }

    public function report($date){
        $cashAccount = CashAccount::where('date', $date)->first();
        $purchase = Purchase::where('purchase_date', $cashAccount->date)->sum('amount');
        $purchasePaid = Purchase::where('purchase_date', $cashAccount->date)->sum('paid');
        $sales = Sale::where('sale_date', $cashAccount->date)->sum('total_arrears');
        $salesPaid = Sale::where('sale_date', $cashAccount->date)->sum('amount_paid');
        $expense = Expense::where('date', $cashAccount->date)->sum('amount');
        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
        }];
        $pdf = Pdf::loadView('cash-accounts.report', compact('cashAccount', 'purchase', 'purchasePaid', 'sales', 'salesPaid', 'expense'),[],$config);
        return $pdf->stream('document.pdf');
//        return view('sales.report', compact('sales','today_rate','totals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CashAccount $cashAccount)
    {
        return view('cash-accounts.edit', compact('cashAccount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CashAccount $cashAccount)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'details' => 'nullable|string',
        ]);

        $cashAccount->update($validated);

        return redirect()->route('cash-accounts.index')
            ->with('success', 'Cash account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CashAccount $cashAccount)
    {
        $cashAccount->delete();

        return redirect()->route('cash-accounts.index')
            ->with('success', 'Cash account deleted successfully.');
    }
}
