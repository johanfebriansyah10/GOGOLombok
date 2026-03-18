<?php

namespace App\Http\Controllers\Admin;

use App\Models\Criteria;
use App\Models\Weight;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWeightRequest;
use App\Http\Requests\UpdateWeightRequest;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weights = Weight::with('criteria')->paginate(10);
        $totalWeight = Weight::totalWeight();
        $isWeightValid = Weight::isWeightValid();

        return view('admin.weights.index', compact('weights', 'totalWeight', 'isWeightValid'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $criterias = Criteria::doesntHave('weight')->get();
        return view('admin.weights.create', compact('criterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWeightRequest $request)
    {
        Weight::create($request->validated());

        return redirect()->route('admin.weights.index')
            ->with('success', 'Bobot berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Weight $weight)
    {
        $weight->load('criteria');
        return view('admin.weights.show', compact('weight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Weight $weight)
    {
        $criterias = Criteria::where('id', $weight->criteria_id)->get();
        return view('admin.weights.edit', compact('weight', 'criterias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWeightRequest $request, Weight $weight)
    {
        $weight->update($request->validated());

        return redirect()->route('admin.weights.index')
            ->with('success', 'Bobot berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weight $weight)
    {
        $weight->delete();

        return redirect()->route('admin.weights.index')
            ->with('success', 'Bobot berhasil dihapus.');
    }
}
