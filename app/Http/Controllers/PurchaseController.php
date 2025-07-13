<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Rate;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use misterspelik\LaravelPdf\Facades\Pdf;

class PurchaseController extends Controller
{

    public function index(Request $request){
        $currentDate = Carbon::parse($request->get('date'));
        $purchases = Purchase::whereDate('purchase_date','=',$currentDate)->get();
        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();

        // Calculate totals
        $totals = [
            'load_weight' => $purchases->sum('load_weight'),
            'net_weight' => $purchases->sum('net_weight'),
            'short_weight' => $purchases->sum('short_weight'),
            'amount' => $purchases->sum('amount'),
        ];

        return view('purchases.index',compact('purchases','today_rate','totals'));
    }

    public function create(Request $request)
    {
        $currentDate = Carbon::parse($request->get('date'));
        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();
        $suppliers = Supplier::where('status',1)->get();

        return view('purchases.create', compact('suppliers','today_rate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'load_weight' => 'required|numeric',
            'net_weight' => 'required|numeric',
            'short_weight' => 'required|numeric',
            'rate_difference' => 'required|numeric',
            'rate' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        $purchase = new Purchase;
        $purchase->fill($request->all());
        $purchase->purchase_date = $validated['purchase_date'];
        $purchase->save();

        session()->flash('success','Record Added Successfully');
        return redirect('supplier-ledger');
    }

    public function edit(Request $request, $id){
        $currentDate = Carbon::parse($request->get('date'));
        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();
        $suppliers = Supplier::where('status',1)->get();

        $purchase = Purchase::find($id);

        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();

        return view('purchases.create', compact('purchase','suppliers','today_rate'));
    }

    public function update(request $request,$id){

        $validated = $request->validate([
            'purchase_date' => 'required|date|unique:purchases,purchase_date',
            'supplier_id' => 'required|exists:suppliers,id',
            'load_weight' => 'required|numeric',
            'net_weight' => 'required|numeric',
            'short_weight' => 'required|numeric',
            'rate_difference' => 'required|numeric',
            'rate' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        $record = Purchase::find($id);
        $record->fill($request->all());
        $record->save();

        session()->flash('success','Record Updated Successfully');
        return redirect('supplier-ledger');
    }

    public function destroy($id){
        $record = Purchase::find($id);
        $record->delete();
        session()->flash('success','Record Deleted Successfully');
        return redirect('supplier-ledger');
    }

    public function report(Request $request){
        $currentDate = Carbon::parse($request->get('date'));
        $purchases = Purchase::whereDate('purchase_date','=',$currentDate)->get();
        $sales = Sale::whereDate('sale_date','=',$currentDate)->get();
        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();

        // Calculate totals
        $totals = [
            'load_weight' => $purchases->sum('load_weight'),
            'net_weight' => $purchases->sum('net_weight'),
            'short_weight' => $purchases->sum('short_weight'),
            'amount' => $purchases->sum('amount'),
            'cash_weight_sale' => $sales->filter(fn($sale) => $sale->client?->category === 'cash')->sum('weight'),
            'credit_weight_sale' => $sales->filter(fn($sale) => $sale->client?->category === 'credit')->sum('weight'),
        ];
        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
        }];
        $data = compact('purchases','today_rate','totals','currentDate');
        $pdf = Pdf::loadView('purchases.report', $data,[],$config);
        return $pdf->stream('document.pdf');
//        return view('purchases.index',compact('purchases','today_rate','totals'));
    }
}
