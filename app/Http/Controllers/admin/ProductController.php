<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Product::query();
        if ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        }
        $products = $query->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products', 'search'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        $product = Product::create($validated);
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store(
                'product-image/' . $product->id,
                'public'
            );
            $product->save();
        }
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function edit(string $id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, string $id)
    {
        $validated = $request->validated();
        $product = Product::find($id);
        $product->update($validated);
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store(
                'product-image/' . $product->id,
                'public'
            );
            $product->save();
        }
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
