<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', now()->format('Y-m'));

        $expenses = Expense::query()
            ->whereYear('date', '=', date('Y', strtotime($selectedMonth)))
            ->whereMonth('date', '=', date('m', strtotime($selectedMonth)))
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('expenses.index', [
            'expenses' => $expenses,
            'selectedMonth' => $selectedMonth
        ]);
    }

    public function create()
    {
        $categories = Expense::categories();
        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);


        $record = new Expense();
        $record->fill($validated);
        $record->save();

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully!');
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $categories = Expense::categories();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully!');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully!');
    }
}
