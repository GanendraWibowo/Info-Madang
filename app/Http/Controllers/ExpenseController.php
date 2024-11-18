<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderBy('expense_date', 'desc')->paginate(10);
        return view('owner.expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('owner.expenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'category' => 'nullable|string|max:100'
        ]);

        Expense::create($validated);

        return redirect()->route('owner.expenses.index')
            ->with('success', 'Expense added successfully');
    }

    public function edit(Expense $expense)
    {
        return view('owner.expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'category' => 'nullable|string|max:100'
        ]);

        $expense->update($validated);

        return redirect()->route('owner.expenses.index')
            ->with('success', 'Expense updated successfully');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('owner.expenses.index')
            ->with('success', 'Expense deleted successfully');
    }
}
