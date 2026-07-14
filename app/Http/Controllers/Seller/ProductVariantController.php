<?php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductVariantController extends Controller
{
    public function index(Product $product)
    {
        if ($product->seller_id !== Auth::guard('seller')->id()) {
            abort(404);
        }

        $variants = $product->variants()->with('color', 'size')->get();
        $colors = Color::all();
        $sizes = Size::all();

        return view('seller.variants.index', compact('product', 'variants', 'colors', 'sizes'));
    }

    public function store(Request $request, Product $product)
    {
        if ($product->seller_id !== Auth::guard('seller')->id()) {
            abort(404);
        }

        $request->validate([
            'color_id.*' => 'required|exists:colors,id',
            'size_id.*' => 'required|exists:sizes,id',
            'price.*' => 'required|numeric|min:1',
            'quantity.*' => 'required|integer|min:0',
            'image.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        foreach ($request->color_id ?? [] as $key => $colorId) {
            if (empty($request->color_id[$key]) || empty($request->size_id[$key]) || empty($request->price[$key])) {
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

        return redirect()->route('seller.variants.index', $product->id)->with('success', 'Variants Added Successfully.');
    }

    public function destroy(ProductVariant $variant)
    {
        if ($variant->product->seller_id !== Auth::guard('seller')->id()) {
            abort(404);
        }

        $variant->delete();
        return back()->with('success', 'Variant Deleted Successfully');
    }
}
