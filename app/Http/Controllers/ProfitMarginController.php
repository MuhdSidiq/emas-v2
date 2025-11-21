<?php

namespace App\Http\Controllers;

use App\Models\ProfitMargin;
use Illuminate\Http\Request;

class ProfitMarginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profitMargins = ProfitMargin::all();
        return view('profit-margins.index', compact('profitMargins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profit-margins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:100',
        ]);

        ProfitMargin::create($validated);

        return redirect()->route('profit-margins.index')
            ->with('success', 'Profit margin created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfitMargin $profitMargin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProfitMargin $profitMargin)
    {
        return view('profit-margins.edit', compact('profitMargin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProfitMargin $profitMargin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:100',
        ]);

        $profitMargin->update($validated);

        return redirect()->route('profit-margins.index')
            ->with('success', 'Profit margin updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfitMargin $profitMargin)
    {
        $profitMargin->delete();

        return redirect()->route('profit-margins.index')
            ->with('success', 'Profit margin deleted successfully.');
    }
}
