<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $categories = $query->latest()->paginate(10);
        return view('kategori.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $kategori)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $kategori->id,
            'description' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $kategori)
    {
        // Cek apakah ada produk yang terhubung dengan kategori ini
        if ($kategori->products()->count() > 0) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
