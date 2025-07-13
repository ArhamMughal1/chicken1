<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Rate;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use misterspelik\LaravelPdf\Facades\Pdf;

class SupplierPurchaseController extends Controller
{
    public function index(Supplier $supplier, Request $request)
    {
        $query = Purchase::where('supplier_id', $supplier->id)
            ->orderBy('purchase_date', 'desc');

        // Default to current month if no month filter is applied
        $selectedMonth = $request->month ?? date('Y-m');

        // Apply month filter
        $query->whereYear('purchase_date', substr($selectedMonth, 0, 4))
            ->whereMonth('purchase_date', substr($selectedMonth, 5, 2));

        $purchases = $query->get();

        return view('suppliers.purchases', [
            'supplier' => $supplier,
            'purchases' => $purchases,
            'selectedMonth' => $selectedMonth
        ]);
    }

    public function report(Supplier $supplier, Request $request){
        $query = Purchase::where('supplier_id', $supplier->id)
            ->orderBy('purchase_date', 'desc');

        $selectedMonth = $request->month ?? date('Y-m');

        $query->whereYear('purchase_date', substr($selectedMonth, 0, 4))
            ->whereMonth('purchase_date', substr($selectedMonth, 5, 2));

        $purchases = $query->get();
        $monthName = date('F Y', strtotime($selectedMonth));

        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
        }];
        $data = compact('supplier','purchases', 'monthName');
        $pdf = Pdf::loadView('suppliers.report', $data,[],$config);
        return $pdf->stream('document.pdf');
    }
}
