<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\CashAccount; // Uncomment if you have a model
use Barryvdh\DomPDF\Facade\Pdf; // Requires `barryvdh/laravel-dompdf`

class CashAccountController extends Controller
{
    public function index()
    {
        // $cashEntries = CashAccount::all(); // Example if using DB
        return view('cash_account.index'/*, compact('cashEntries')*/);
    }

    public function create()
    {
        return view('cash_account.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type'   => 'required|in:credit,debit',
            'notes'  => 'nullable|string|max:255',
        ]);

        // CashAccount::create($validated);

        return redirect()->route('cash_account.index')->with('success', 'Cash entry added successfully!');
    }

    // ✅ View PDF in browser
    public function viewPdf()
    {
        // $cashEntries = CashAccount::all();
        $pdf = Pdf::loadView('cash_account.report'/*, compact('cashEntries')*/);
        return $pdf->stream('cash-account-report.pdf');
    }

    // ✅ Download PDF directly
    public function downloadPdf()
    {
        // $cashEntries = CashAccount::all();
        $pdf = Pdf::loadView('cash_account.report'/*, compact('cashEntries')*/);
        return $pdf->download('cash-account-report.pdf');
    }
}
