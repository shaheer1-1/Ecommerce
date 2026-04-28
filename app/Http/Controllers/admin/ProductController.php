<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Traits\Search;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use Search;

    public function index(Request $request)
    {
        $query = Product::query();
        $search = $this->applyNameSearch($query, $request);
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
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $destinationPath = "product-image/";
            $fileName = $file->getClientOriginalName();
            $newFileName = getFileName_uniq($destinationPath, $fileName);
            $filePath = Storage::putFileAs($destinationPath, $file, $newFileName);
            $product = Product::find($product->id);

            if( $product->image != '' && Storage::exists($product->image) )
            {
                Storage::delete($product->image);
            }

            $product->image = $filePath;
        }

        $product->save();
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
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
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
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
