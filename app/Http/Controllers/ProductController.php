<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'user']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(9)->withQueryString();
        $categories = Categorie::all();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'user', 'post']);

        return view('shop.show', compact('product'));
    }

    public function myProducts()
    {
        $products = Product::where('user_id', auth()->id())
            ->with(['category'])
            ->latest()
            ->paginate(9);

        return view('products.my-products', compact('products'));
    }

    public function create()
    {
        $categories = Categorie::all();
        $posts = Post::where('user_id', auth()->id())->get();

        return view('products.create', compact('categories', 'posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'post_id' => 'nullable|exists:posts,id',
        ]);

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.myProducts')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== auth()->id() && ! auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = Categorie::all();
        $posts = Post::where('user_id', auth()->id())->get();

        return view('products.edit', compact('product', 'categories', 'posts'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== auth()->id() && ! auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'post_id' => 'nullable|exists:posts,id',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.myProducts')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id() && ! auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('shop.index')->with('success', 'Product deleted successfully.');
    }
}
