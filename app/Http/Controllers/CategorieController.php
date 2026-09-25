<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::withCount('posts')->latest()->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Categorie::create($validated);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Categorie $categorie)
    {
        return view('categories.edit', ['category' => $categorie]);
    }

    public function update(Request $request, Categorie $categorie)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$categorie->id,
            'description' => 'nullable|string',
        ]);

        $categorie->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Categorie $categorie)
    {
        if ($categorie->posts()->exists() || $categorie->products()->exists()) {
            return back()->with('error', 'Cannot delete a category that still has posts or products.');
        }

        $categorie->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
