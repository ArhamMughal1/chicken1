<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RateController extends Controller
{
    public function index(Request $request){
        $currentMonth = Carbon::parse($request->get('month'));
        $rates = Rate::whereMonth('price_date', '=', $currentMonth)->get();

        return view('rates.index', compact('rates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'price_date' => 'required|date|unique:rates,price_date',
            'mandi_rate' => 'required|numeric|between:0,99999999.99',
            'slate_rate' => 'required|numeric|between:0,999999.99',
        ]);

        $record = new Rate();
        $record->fill($request->all());
        $record->save();

        session()->flash('success', "Record added successfully!");
        return redirect('rate-list');
    }

    public function edit(Request $request, $id)
    {
        $currentMonth = Carbon::parse($request->get('month'));
        $rates = Rate::whereMonth('price_date', '=', $currentMonth)->get();

        $rate = Rate::find($id);
        return view('rates.index', compact('rate', 'rates'));
    }

    public function update(Request $request, $id)
    {
        $rate = Rate::find($id);
        $rate->fill($request->all());
        $rate->save();
        session()->flash('success','Record Updated Successfully');
        return redirect('rate-list');
    }
}
