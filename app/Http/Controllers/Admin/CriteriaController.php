<?php

namespace App\Http\Controllers\Admin;

use App\Models\Criteria;
use App\Models\Weight;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCriteriaRequest;
use App\Http\Requests\UpdateCriteriaRequest;
use App\Http\Requests\StoreWeightRequest;
use App\Http\Requests\UpdateWeightRequest;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Display a combined listing of criterias and weights
     */
    public function index()
    {
        $criterias = Criteria::with('weight')->paginate(10);
        $weights = Weight::with('criteria')->paginate(10);
        $totalWeight = Weight::totalWeight();
        $isWeightValid = Weight::isWeightValid();

        return view('admin.criterias.index', compact(
            'criterias',
            'weights',
            'totalWeight',
            'isWeightValid'
        ));
    }

    /**
     * Show the form for creating a new criteria
     */
    public function create()
    {
        return view('admin.criterias.create');
    }

    /**
     * Store a newly created criteria
     */
    public function store(StoreCriteriaRequest $request)
    {
        Criteria::create($request->validated());

        return redirect()->route('admin.criterias.index')
            ->with('success', 'Kriteria berhasil dibuat.');
    }

    /**
     * Show the form for editing a criteria
     */
    public function edit(Criteria $criteria)
    {
        return view('admin.criterias.edit', compact('criteria'));
    }

    /**
     * Update the specified criteria
     */
    public function update(UpdateCriteriaRequest $request, Criteria $criteria)
    {
        $criteria->update($request->validated());

        return redirect()->route('admin.criterias.index')
            ->with('success', 'Kriteria berhasil diubah.');
    }

    /**
     * Remove the specified criteria
     */
    public function destroy(Criteria $criteria)
    {
        $criteria->delete();

        return redirect()->route('admin.criterias.index')
            ->with('success', 'Kriteria berhasil dihapus.');
    }

    /**
     * Show the form for creating a new weight
     */
    public function createWeight()
    {
        $criterias = Criteria::doesntHave('weight')->get();
        return view('admin.criterias.create-weight', compact('criterias'));
    }

    /**
     * Store a newly created weight
     */
    public function storeWeight(StoreWeightRequest $request)
    {
        Weight::create($request->validated());

        return redirect()->route('admin.criterias.index')
            ->with('success', 'Bobot berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a weight
     */
    public function editWeight(Weight $weight)
    {
        $criterias = Criteria::where('id', $weight->criteria_id)->get();
        return view('admin.criterias.edit-weight', compact('weight', 'criterias'));
    }

    /**
     * Update the specified weight
     */
    public function updateWeight(UpdateWeightRequest $request, Weight $weight)
    {
        $weight->update($request->validated());

        return redirect()->route('admin.criterias.index')
            ->with('success', 'Bobot berhasil diubah.');
    }

    /**
     * Remove the specified weight
     */
    public function destroyWeight(Weight $weight)
    {
        $weight->delete();

        return redirect()->route('admin.criterias.index')
            ->with('success', 'Bobot berhasil dihapus.');
    }
}
