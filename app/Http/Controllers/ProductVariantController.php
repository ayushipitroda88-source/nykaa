<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index(Product $product)
{
    $variants = $product->variants()
        ->with('color', 'size')
        ->get();

    $colors = Color::all();
    $sizes = Size::all();

    return view('variants.index', compact(
        'product',
        'variants',
        'colors',
        'sizes'
    ));
}

    public function create(Product $product)
    {
        $colors = Color::all();
        $sizes = Size::all();

        return view('variants.create', compact('product','colors','sizes'));
    }
    public function store(Request $request, Product $product)
{
    


    $request->validate([
        'color_id.*' => 'required|exists:colors,id',
        'size_id.*' => 'required|exists:sizes,id',
        'price.*' => 'required|numeric|min:1',
        'quantity.*' => 'required|integer|min:0',
        'image.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

   foreach ($request->color_id ?? [] as $key => $colorId) {

        if (
            empty($request->color_id[$key]) ||
            empty($request->size_id[$key]) ||
            empty($request->price[$key])
        ) {
            continue;
        }

        $imageName = null;

        if ($request->hasFile("image.$key")) {

            $file = $request->file("image.$key");

            $imageName = time().'_'.$key.'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/variants'), $imageName);
        }

        ProductVariant::create([

            'product_id' => $product->id,

            'color_id' => $request->color_id[$key],

            'size_id' => $request->size_id[$key],

            'price' => $request->price[$key],

            'quantity' => $request->quantity[$key],

            'image' => $imageName,

        ]);
    }

    return redirect()
        ->route('variants.index', $product->id)
        ->with('success', 'Variants Added Successfully.');
}
    public function edit(ProductVariant $variant)
{
    $colors = Color::all();
    $sizes = Size::all();

    return view('variants.edit', compact('variant', 'colors', 'sizes'));
}

public function update(Request $request, ProductVariant $variant)
{
    $request->validate([
        'color_id' => 'required',
        'size_id' => 'required',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
    ]);

    if ($request->hasFile('image')) {

        $image = time().'.'.$request->image->extension();

        $request->image->move(public_path('uploads/variants'), $image);

        $variant->image = $image;
    }

    $variant->color_id = $request->color_id;
    $variant->size_id = $request->size_id;
    $variant->price = $request->price;
    $variant->quantity = $request->quantity;

    $variant->save();

    return redirect()->route('variants.index', $variant->product_id)
        ->with('success', 'Variant Updated Successfully');
}

public function destroy(ProductVariant $variant)
{
    $variant->delete();

    return back()->with('success', 'Variant Deleted Successfully');
}
}