<?php

namespace App\Http\Controllers;

use App\Models\GodownWeight;
use App\Models\Purchase;
use App\Models\{
    Rate,
    WeightShortage
};
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use misterspelik\LaravelPdf\Facades\Pdf;

class PurchaseController extends Controller
{

    public function index(Request $request){


        $currentDate = Carbon::parse($request->get('date'));
        $sales = Sale::whereDate('sale_date','=',$currentDate)->get();
        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();

        $purchases = Purchase::whereDate('purchase_date','=',$currentDate)->get();

        $shortages = WeightShortage::where('date', $currentDate)->get();

        // Calculate totals
       


        $currentDate = Carbon::parse($request->get('date'));
        $purchases = Purchase::whereDate('purchase_date','=',$currentDate)->get();
        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();
         $totals = [
            'weight' => $sales->sum('weight'),
            'amount' => $sales->sum('amount'),
            'amount_paid' => $sales->sum('amount_paid'),
            'arrears' => $sales->sum('arrears'),
            'previous_arrears' => $sales->sum('previous_arrears'),
            'total_arrears' => $sales->sum('total_arrears'),

            'load_weight' => $purchases->sum('load_weight'),
            'net_weight' => $purchases->sum('net_weight'),
            'short_weight' => $shortages->sum('shortage_amount'),
            'cash_weight_sale' => $sales->filter(fn($sale) => $sale->client?->category === 'cash')->sum('weight'),
            'credit_weight_sale' => $sales->filter(fn($sale) => $sale->client?->category === 'credit')->sum('weight'),
            
            'supp_load_weight' => $purchases->sum('load_weight'),
            'supp_net_weight' => $purchases->sum('net_weight'),
            'supp_short_weight' => $purchases->sum('short_weight'),
            'supp_amount' => $purchases->sum('amount'),
            'supp_paid' => $purchases->sum('paid'),
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
            'amount' => 'required|numeric'
        ]);
        $purchase = new Purchase;
        $purchase->fill($request->all());
        if($request->has('godown_select') && !empty($request->godown_select)){
            $purchase->amount = $request->godown_rate_total ?? $purchase->amount;
            $godown = GodownWeight::where('date', $request->godown_select)->first()->value('id');
            $purchase->godown = $godown;
            $purchase->net_weight = $purchase->net_weight + $request->godown_weight;
            GodownWeight::where('id', $godown)->update([
                'used' => 1,
                'supplier_id' => $request->supplier_id
            ]);
        }
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
            'purchase_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'load_weight' => 'required|numeric',
            'net_weight' => 'required|numeric',
            'short_weight' => 'required|numeric',
            'rate_difference' => 'required|numeric',
            'rate' => 'required|numeric',
            'amount' => 'required|numeric',
            'paid' => 'numeric',
            'description' => 'nullable|string'
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

        $currentDateClient = Carbon::parse($request->get('date'));
        $salesClient = Sale::whereDate('sale_date','=',$currentDateClient)->get();
        $today_rate_client = Rate::whereDate('price_date', '=', $currentDateClient)->first();

        $currentDate = Carbon::parse($request->get('date'));
        $purchases = Purchase::whereDate('purchase_date','=',$currentDate)->get();
        $sales = Sale::whereDate('sale_date','=',$currentDate)->get();
        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();

        // Calculate totals
        $totals = [
            'weight_client' => $salesClient->sum('weight'),
            'amount_client' => $salesClient->sum('amount'),
            'amount_paid_client' => $salesClient->sum('amount_paid'),
            'arrears_client' => $salesClient->sum('arrears'),
            'previous_arrears_client' => $salesClient->sum('previous_arrears'),
            'total_arrears_client' => $salesClient->sum('total_arrears'),

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
        $data = compact('purchases','today_rate','totals','currentDate', 'today_rate_client', 'salesClient');
        $pdf = Pdf::loadView('purchases.report', $data,[],$config);
        return $pdf->stream('document.pdf');
//        return view('purchases.index',compact('purchases','today_rate','totals'));
    }
}
