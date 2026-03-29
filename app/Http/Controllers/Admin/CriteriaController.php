<?php

namespace App\Http\Controllers\Admin;

use App\Models\Criteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCriteriaRequest;
use App\Http\Requests\UpdateCriteriaRequest;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criterias = Criteria::with('weight')->paginate(10);
        return view('admin.criterias.index', compact('criterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.criterias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCriteriaRequest $request)
    {
        Criteria::create($request->validated());

        return redirect()->route('admin.criterias.index')
            ->with('success', 'Kriteria berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Criteria $criteria)
    {
        $criteria->load('weight');
        return view('admin.criterias.show', compact('criteria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Criteria $criteria)
    {
        return view('admin.criterias.edit', compact('criteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCriteriaRequest $request, Criteria $criteria)
    {
        $criteria->update($request->validated());

        return redirect()->route('admin.criterias.index')
            ->with('success', 'Kriteria berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criteria $criteria)
    {
        $criteria->delete();

        return redirect()->route('admin.criterias.index')
            ->with('success', 'Kriteria berhasil dihapus.');
    }
}
