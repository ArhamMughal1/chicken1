<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Sale;
use Illuminate\Http\Request;
use misterspelik\LaravelPdf\Facades\Pdf;

class ClientSaleController extends Controller
{
    public function index(Client $client, Request $request)
    {
        $query = Sale::where('client_id', $client->id)
            ->orderBy('sale_date', 'desc');

        if ($request->month) {
            $query->whereYear('sale_date', substr($request->month, 0, 4))
                ->whereMonth('sale_date', substr($request->month, 5, 2));
        }

        $sales = $query->get(); // Changed from paginate() to get()

        return view('clients.sales', compact('client', 'sales'));
    }

    public function report(Client $client, Request $request){
        $query = Sale::where('client_id', $client->id)
            ->orderBy('sale_date', 'desc');

        $selectedMonth = $request->month ?? date('Y-m');

        $query->whereYear('sale_date', substr($selectedMonth, 0, 4))
            ->whereMonth('sale_date', substr($selectedMonth, 5, 2));

        $sales = $query->get();
        $monthName = date('F Y', strtotime($selectedMonth));

        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
        }];
        $data = compact('client','sales', 'monthName');
        $pdf = Pdf::loadView('clients.report', $data,[],$config);
        return $pdf->stream('document.pdf');
    }
}
