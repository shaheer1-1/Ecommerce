<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CategoryRequest;
class CategoryController extends Controller
{
    use Search;

    public function index(Request $request)
    {
        $query = Category::query();
        $search = $this->applyNameSearch($query, $request);
        $categories = $query->paginate(10)->withQueryString();
        return view('admin.categories.index', compact('categories', 'search'));
    }
    public function create()
    {
        return view('admin.categories.create');
    }
    public function store(CategoryRequest $request)
{
    $validated = $request->validated();

    $category = Category::create($validated);
    if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $destinationPath = "category-image/";
            $fileName = $file->getClientOriginalName();
            $newFileName = getFileName_uniq($destinationPath, $fileName);
            $filePath = Storage::putFileAs($destinationPath, $file, $newFileName);
            $category = Category::find($category->id);

            if( $category->image != '' && Storage::exists($category->image) )
            {
                Storage::delete($category->image);
            }

            $category->image = $filePath;
        }

        $category->save();
    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Category created successfully');
}

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, string $id)
    {
        $validated = $request->validated();
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
