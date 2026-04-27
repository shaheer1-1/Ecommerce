<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Category::query();
        if ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        }
        $categories = $query->paginate(10)->withQueryString();
        return view('admin.categories.index', compact('categories', 'search'));
    }
    public function create()
    {
        return view('admin.categories.create');
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
    ]);

    $category = Category::create([
        'name' => $validated['name'],
    ]);
    if ($request->hasFile('image')) {
        $category->image = $request->file('image')->store(
            'category-image/' . $category->id,
            'public'
        );
        $category->save();
    }
    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Category created successfully');
}

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);
        $category = Category::find($id);
        $category->update($validated);
        if ($request->hasFile('image')) {
            $category->image = $request->file('image')->store(
                'category-image/' . $category->id,
                'public'
            );
            $category->save();
        }
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
