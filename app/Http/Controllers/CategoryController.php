<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
// use Illuminate\Database\Eloquent\Collection;

class CategoryController extends Controller
{
    public function index()
    {
        $allCategories = Category::with('children')->get();
        $categories = Category::whereNull('parent_id')
        ->with('children.children')
        ->get();

        return view('categories.index', compact('allCategories', 'categories'));
    }

    public function create()
{
    $categories = Category::all();

    return view('categories.create', compact('categories'));
}
     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'position' => 'nullable|integer',
        ]);
     
        $category = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id ?: null, // khaali ho to root category
            'position' => $request->position ?? 0,
            'status' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category add ho gayi!',
            'category' => $category,
        ]);
    }

    public function show($id)
{
    $category = Category::with([
        'children.children',
        'parent',
    ])->findOrFail($id);

    // Current Category + Children + Grand Children
    $categoryIds = collect([$category->id]);

    foreach ($category->children as $child) {

        $categoryIds->push($child->id);

        foreach ($child->children as $sub) {

            $categoryIds->push($sub->id);

        }

    }
    $products = Product::whereIn('category_id', $categoryIds)->paginate(12);

    return view('user.category', compact(
        'category',
        'products'
    ));
}
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|integer',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'position' => $request->position ?? $category->position,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Naam update ho gaya!',
            'category' => $category,
        ]);
    }

    
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category delete ho gayi!',
        ]);
    }
}
