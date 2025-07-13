<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\WeightShortage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WeightShortageController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = Carbon::parse($request->get('date'));
        $shortages = WeightShortage::with('driver')
            ->whereDate('date','=',$currentDate)
            ->get();

        return view('weight_shortages.index', compact('shortages'));
    }

    public function create()
    {
        $drivers = Driver::orderBy('name')->get();
        return view('weight_shortages.create', compact('drivers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'date' => 'required|date',
            'shortage_amount' => 'required|numeric|min:0',
            'details' => 'nullable|string',
        ]);

        WeightShortage::create($request->all());

        return redirect()->route('weight-shortages.index')
            ->with('success', 'Weight shortage recorded successfully.');
    }

    public function show(WeightShortage $weightShortage)
    {
        return view('weight_shortages.show', compact('weightShortage'));
    }

    public function edit(WeightShortage $weightShortage)
    {
        $drivers = Driver::orderBy('name')->get();
        return view('weight_shortages.edit', compact('weightShortage', 'drivers'));
    }

    public function update(Request $request, WeightShortage $weightShortage)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'date' => 'required|date',
            'shortage_amount' => 'required|numeric|min:0',
            'details' => 'nullable|string',
        ]);

        $weightShortage->update($request->all());

        return redirect()->route('weight-shortages.index')
            ->with('success', 'Weight shortage updated successfully');
    }

    public function destroy(WeightShortage $weightShortage)
    {
        $weightShortage->delete();

        return redirect()->route('weight-shortages.index')
            ->with('success', 'Weight shortage record deleted successfully');
    }
}
