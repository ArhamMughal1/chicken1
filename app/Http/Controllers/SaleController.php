<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Purchase;
use App\Models\Rate;
use App\Models\Sale;
//use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\WeightShortage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use misterspelik\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Validator;
class SaleController extends Controller
{
    public function index(Request $request){
        $currentDate = Carbon::parse($request->get('date'));
        $sales = Sale::whereDate('sale_date','=',$currentDate)->get();
        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();

        $purchases = Purchase::whereDate('purchase_date','=',$currentDate)->get();

        $shortages = WeightShortage::where('date', $currentDate)->get();

        // Calculate totals
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

        ];


        return view('sales.index', compact('sales','today_rate','totals'));
    }

    public function create(Request $request)
    {
        $categories = Client::distinct()->pluck('category');

        $currentDate = Carbon::parse($request->get('date'));

        $clients = Client::where('status',1)->get();

        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();
        $clientsData = $clients->map(function($client) {
            return [
                'id' => $client->id,
                'full_name' => $client->full_name,
                'discount' => $client->discount ?? 0,
                'balance' => $client->balance ?? 0,
                'category' => $client->category
            ];
        });
        $clientsJson = $clientsData->toJson();
        $purchaseWeight = Purchase::whereDate('purchase_date', request('date', now()->format('Y-m-d')))
            ->sum('net_weight');

        $soldWeight = Sale::whereDate('sale_date', request('date', now()->format('Y-m-d')))
            ->sum('weight');

        $remainingWeight = $purchaseWeight - $soldWeight;

        return view('sales.create', compact('clients','today_rate', 'categories', 'clientsJson', 'remainingWeight', 'purchaseWeight'));
    }

    public function store(request $request){
        $validated = $request->validate([
            'sale_date' => 'required|date',
            'clients' => 'required|array',
            'clients.*.client_id' => 'required|exists:clients,id',
            'clients.*.weight' => 'required|numeric',
            'clients.*.amount' => 'required|numeric',
            'clients.*.amount_paid' => 'required|numeric',
            'clients.*.arrears' => 'required|numeric',
            'clients.*.previous_arrears' => 'required|numeric',
            'clients.*.total_arrears' => 'required|numeric',
            'clients.*.description' => 'nullable|string'
        ]);
        $totalSale = 0;
        foreach ($validated['clients'] as $clientData) {
            $totalSale += $clientData['weight'];
        }
        $purchase = Purchase::where('purchase_date', $validated['sale_date'])->sum('net_weight');
        if($totalSale > $purchase){
            return redirect()->back()->with('error', "Max Net Weight Reached.");
        }
        foreach ($validated['clients'] as $clientData) {
            if(Sale::where('sale_date', $validated['sale_date'])->where('client_id', $clientData)->exists()){
                $totalSale += $clientData['weight'];
                $clientData['sale_date'] = $validated['sale_date'];
                Sale::where('sale_date', $validated['sale_date'])->where('client_id', $clientData)
                ->update($clientData);
                $client = Client::find($clientData['client_id']);
                $client->update(['balance' => $clientData['total_arrears']]);
            }else{
                $sale = new Sale;
                $totalSale += $clientData['weight'];
                $sale->fill($clientData);
                $sale->sale_date = $validated['sale_date'];
                $sale->save();

                $client = Client::find($clientData['client_id']);
                $client->update(['balance' => $clientData['total_arrears']]);
            }
        }

        session()->flash('success','Record Added Successfully');
        return redirect('client-ledger');
    }

    public function getInitialData(Request $request)
    {
        $currentDate = $request->query('date', now()->format('Y-m-d'));

        $purchaseWeight = Purchase::whereDate('purchase_date', $currentDate)
            ->sum('net_weight');

        $soldWeight = Sale::whereDate('sale_date', $currentDate)
            ->sum('weight');

        $shortages = WeightShortage::whereDate('date','=', $currentDate)->sum('shortage_amount');

        $remainingWeight = $purchaseWeight - ($shortages + $soldWeight);

        // Get existing sales for the date
        $existingSales = Sale::with('client')
            ->whereDate('sale_date', $currentDate)
            ->get()
            ->keyBy('client_id');

        // Get weight by category
        $weightByCategory = Sale::join('clients', 'sales.client_id', '=', 'clients.id')
            ->whereDate('sale_date', $currentDate)
            ->selectRaw('clients.category, SUM(sales.weight) as total_weight')
            ->groupBy('clients.category')
            ->pluck('total_weight', 'category');

        $clients = Client::where('status',1)->get()->map(function($client) use ($existingSales) {
            $sale = $existingSales->get($client->id);

            return [
                'id' => $client->id,
                'full_name' => $client->full_name,
                'discount' => $client->discount ?? 0,
                'balance' => $client->balance ?? 0,
                'category' => $client->category,
                'sale' => $sale ? [
                    'rate_difference' => $sale->rate_difference,
                    'weight' => $sale->weight,
                    'amount_paid' => $sale->amount_paid,
                    'previous_arrears' => $sale->previous_arrears,
                    'description' => $sale->description
                ] : null
            ];
        });

        return response()->json([
            'clients' => $clients,
            'purchaseWeight' => $purchaseWeight,
            'weightShortage' => $shortages,
            'remainingWeight' => $remainingWeight,
            'weightByCategory' => $weightByCategory
        ]);
    }

    public function edit(Request $request, $id){

        $sale = Sale::find($id);
        $currentDate = Carbon::parse($request->get('date'));
        $clients = Client::where('status',1)->get();

        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();

        return view('sales.edit', compact('sale','clients','today_rate'));
    }

    public function batchEdit(Request $request, $date)
    {
        $categories = Client::distinct()->pluck('category');
        $currentDate = Carbon::parse($date);

        // Get all active clients
        $clients = Client::where('status', 1)->get();

        // Get today's rate
        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();

        // Get existing sales for the date
        $existingSales = Sale::whereDate('sale_date', $currentDate)
            ->get()
            ->keyBy('client_id');

        // Prepare client data with their existing sales if any
        $clientsData = $clients->map(function($client) use ($existingSales) {
            $sale = $existingSales->get($client->id);

            return [
                'id' => $client->id,
                'full_name' => $client->full_name,
                'discount' => $client->discount ?? 0,
                'balance' => $client->balance ?? 0,
                'category' => $client->category,
                'sale' => $sale ? [
                    'rate_difference' => $sale->rate_difference,
                    'weight' => $sale->weight,
                    'amount_paid' => $sale->amount_paid,
                    'previous_arrears' => $sale->previous_arrears,
                ] : null
            ];
        });

        $clientsJson = $clientsData->toJson();

        // Calculate weights
        $purchaseWeight = Purchase::whereDate('purchase_date', $currentDate)
            ->sum('net_weight');

        $soldWeight = Sale::whereDate('sale_date', $currentDate)
            ->sum('weight');

        $remainingWeight = $purchaseWeight - $soldWeight;

        return view('sales.batch-edit', compact(
            'date',
            'clients',
            'today_rate',
            'categories',
            'clientsJson',
            'remainingWeight',
            'purchaseWeight'
        ));
    }

    public function batchUpdate(Request $request, $date)
    {
        $validated = $request->validate([
            'sale_date' => 'required|date',
            'clients' => 'required|array',
            'clients.*.client_id' => 'required|exists:clients,id',
            'clients.*.rate_difference' => 'required|numeric',
            'clients.*.rate' => 'required|numeric',
            'clients.*.weight' => 'required|numeric',
            'clients.*.amount' => 'required|numeric',
            'clients.*.amount_paid' => 'required|numeric',
            'clients.*.arrears' => 'required|numeric',
            'clients.*.previous_arrears' => 'required|numeric',
            'clients.*.total_arrears' => 'required|numeric',
        ]);

        // Process each client sale
        foreach ($request->clients as $clientData) {
            $sale = Sale::updateOrCreate(
                [
                    'client_id' => $clientData['client_id'],
                    'sale_date' => $date
                ],
                [
                    'rate_difference' => $clientData['rate_difference'],
                    'rate' => $clientData['rate'],
                    'weight' => $clientData['weight'],
                    'amount' => $clientData['amount'],
                    'amount_paid' => $clientData['amount_paid'],
                    'arrears' => $clientData['arrears'],
                    'previous_arrears' => $clientData['previous_arrears'],
                    'total_arrears' => $clientData['total_arrears'],
                ]
            );

            $client = Client::find($clientData['client_id']);
            $client->update(['balance' => $clientData['total_arrears']]);
        }

        return redirect()->route('sale.index')->with('success', 'Sales updated successfully');
    }

    public function update(request $request,$id){

        $request->validate([
            'rate_difference' => 'required|numeric',
            'rate' => 'required|numeric',
            'weight' => 'required|numeric',
            'amount' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'arrears' => 'required|numeric',
            'previous_arrears' => 'required|numeric',
            'total_arrears' => 'required|numeric',
        ]);

        $sale = Sale::find($id);
        $sale->fill($request->all());
        $sale->save();

        $client = Client::find($request->get('client_id'));
        $client->update(['balance' => $request->get('total_arrears')]);

        session()->flash('success','Record Updated Successfully');
        return redirect('client-ledger');
    }
    public function destroy($id){
        $sale = Sale::find($id);
        $sale->delete();
        session()->flash('success','Record Deleted Successfully');
        return redirect('client-ledger');
    }

    public function report(Request $request){
        $currentDate = Carbon::parse($request->get('date'));
        $sales = Sale::whereDate('sale_date','=',$currentDate)->get();
        $today_rate = Rate::whereDate('price_date', '=', $currentDate)->first();

        // Calculate totals
        $totals = [
            'weight' => $sales->sum('weight'),
            'amount' => $sales->sum('amount'),
            'amount_paid' => $sales->sum('amount_paid'),
            'arrears' => $sales->sum('arrears'),
            'previous_arrears' => $sales->sum('previous_arrears'),
            'total_arrears' => $sales->sum('total_arrears'),
        ];

        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
        }];

        $data = compact('sales','today_rate','totals','currentDate');
        $pdf = Pdf::loadView('sales.report', $data,[],$config);
        return $pdf->stream('document.pdf');
//        return view('sales.report', compact('sales','today_rate','totals'));
    }
}
