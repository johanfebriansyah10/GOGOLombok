<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WisataController extends Controller
{
    /**
     * Display a listing of wisatas.
     */
    public function index()
    {
        $wisatas = Wisata::with('category')->get();
        return view('admin.wisatas.index', compact('wisatas'));
    }

    /**
     * Show the form for creating a new wisata.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.wisatas.create', compact('categories'));
    }

    /**
     * Store a newly created wisata in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'rating' => 'required|integer|between:1,5',
            'ticket_price' => 'required|numeric|min:0',
            'distance' => 'required|numeric|min:0',
            'facilities_count' => 'required|integer|min:0',
            'actual_rating' => 'required|numeric|between:0,5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('wisatas', 'public');
            $validated['image'] = $imagePath;
        }

        Wisata::create($validated);

        return redirect()->route('admin.wisatas.index')->with('success', 'Wisata berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified wisata.
     */
    public function edit(Wisata $wisata)
    {
        $categories = Category::all();
        return view('admin.wisatas.edit', compact('wisata', 'categories'));
    }

    /**
     * Update the specified wisata in storage.
     */
    public function update(Request $request, Wisata $wisata)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'rating' => 'required|integer|between:1,5',
            'ticket_price' => 'required|numeric|min:0',
            'distance' => 'required|numeric|min:0',
            'facilities_count' => 'required|integer|min:0',
            'actual_rating' => 'required|numeric|between:0,5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($wisata->image && Storage::disk('public')->exists($wisata->image)) {
                Storage::disk('public')->delete($wisata->image);
            }
            $imagePath = $request->file('image')->store('wisatas', 'public');
            $validated['image'] = $imagePath;
        }

        $wisata->update($validated);

        return redirect()->route('admin.wisatas.index')->with('success', 'Wisata berhasil diperbarui');
    }

    /**
     * Remove the specified wisata from storage.
     */
    public function destroy(Wisata $wisata)
    {
        // Delete image if exists
        if ($wisata->image && Storage::disk('public')->exists($wisata->image)) {
            Storage::disk('public')->delete($wisata->image);
        }

        $wisata->delete();

        return redirect()->route('admin.wisatas.index')->with('success', 'Wisata berhasil dihapus');
    }
}
