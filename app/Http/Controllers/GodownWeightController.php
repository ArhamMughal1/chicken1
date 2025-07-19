<?php

namespace App\Http\Controllers;

use App\Models\{
    GodownWeight,
    Sale,
    Purchase
};
use Illuminate\Http\Request;

class GodownWeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weights = GodownWeight::latest()->paginate(10);
        return view('godown-weights.index', compact('weights'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('godown-weights.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'remaining_weight' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);
        $today_date = today();
        $purchases = Purchase::whereDate('purchase_date','=',$today_date)->get();
        $sales = Sale::whereDate('sale_date','=',$today_date)->get();
        $today_weight_purchase = $purchases->sum('net_weight');
        $today_weight_sale = $sales->sum('weight');
        if(($today_weight_purchase - $today_weight_sale) < $request->remaining_weight){
            return redirect()->route('godown-weights.index')
            ->with('error', 'Godown weight exceeded.');
        }
        GodownWeight::create($validated);

        return redirect()->route('godown-weights.index')
            ->with('success', 'Godown weight record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GodownWeight $godownWeight)
    {
        return view('godown-weights.show', compact('godownWeight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GodownWeight $godownWeight)
    {
        return view('godown-weights.edit', compact('godownWeight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GodownWeight $godownWeight)
    {
        $validated = $request->validate([
            'remaining_weight' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $godownWeight->update($validated);

        return redirect()->route('godown-weights.index')
            ->with('success', 'Godown weight record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GodownWeight $godownWeight)
    {
        $godownWeight->delete();

        return redirect()->route('godown-weights.index')
            ->with('success', 'Godown weight record deleted successfully.');
    }
}
