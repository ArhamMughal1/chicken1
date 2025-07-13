<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Purchase;
use App\Models\Rate;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today_date = today();
        $total_clients = Client::where('status',1)->get()->count();
        $total_suppliers = Supplier::where('status',1)->get()->count();
        $today_rate = Rate::whereDate('price_date', '=', $today_date)->first();
        $purchases = Purchase::whereDate('purchase_date','=',$today_date)->get();
        $sales = Sale::whereDate('sale_date','=',$today_date)->get();
        $today_weight_purchase = $purchases->sum('net_weight');
        $today_weight_sale = $sales->sum('weight');
        $today_remaining_weight = $today_weight_purchase - $today_weight_sale;
        return view('dashboard',compact('today_rate','total_clients','total_suppliers','today_weight_purchase','today_weight_sale', 'today_remaining_weight'));
    }
}
