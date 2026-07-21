<?php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\VariantSize;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductVariantController extends Controller
{
    public function index(Product $product)
    {
        $sellerId = Auth::guard('seller')->id();
        if ($product->seller_id !== $sellerId) {
            abort(404);
        }

        $variants = $product->variants()->with('color', 'sizes.size')->orderBy('priority', 'asc')->get();
        $colors = Color::forSeller($sellerId)->get();
        $sizes = Size::forSeller($sellerId)->get();

        $usedColorIds = $variants->pluck('color_id')->toArray();
        $availableColors = $colors->reject(function ($color) use ($usedColorIds) {
            return in_array($color->id, $usedColorIds);
        })->values(); // re-index

        return view('seller.variants.index', compact('product', 'variants', 'colors', 'sizes', 'availableColors'));
    }

    public function sync(Request $request, Product $product)
    {
        $sellerId = Auth::guard('seller')->id();
        if ($product->seller_id !== $sellerId) {
            abort(404);
        }

        $request->validate([
            'variants' => 'nullable|array',
            'variants.*.priority' => 'required|integer|min:1',
            'variants.*.color_id' => 'required|exists:colors,id|distinct',
            'variants.*.sku' => 'nullable|string|max:255',
            'variants.*.status' => 'required|boolean',
            'variants.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'variants.*.sizes' => 'nullable|array',
            'variants.*.sizes.*.size_id' => 'required|exists:sizes,id',
            'variants.*.sizes.*.price' => 'required|numeric|min:0',
            'variants.*.sizes.*.original_price' => 'nullable|numeric|min:0',
            'variants.*.sizes.*.quantity' => 'required|integer|min:0',
        ]);

        $submittedVariantIds = [];
        $existingIds = [];

        foreach ($request->variants ?? [] as $variantData) {
            if (!empty($variantData['id'])) {
                $existingIds[] = $variantData['id'];
            }
        }

        if (!empty($existingIds)) {
            // Temporarily bump priorities to avoid unique constraint violations during swap
            ProductVariant::whereIn('id', $existingIds)
                ->where('product_id', $product->id)
                ->update(['priority' => \Illuminate\Support\Facades\DB::raw('priority + 10000')]);
        }

        foreach ($request->variants ?? [] as $index => $variantData) {
            $variantId = $variantData['id'] ?? null;

            // Security check color
            $color = Color::forSeller($sellerId)->find($variantData['color_id']);
            if (!$color) continue;

            $variantPayload = [
                'product_id' => $product->id,
                'color_id' => $variantData['color_id'],
                'priority' => $variantData['priority'],
                'sku' => $variantData['sku'] ?? null,
                'status' => $variantData['status'],
            ];

            if (isset($variantData['image']) && $request->hasFile("variants.$index.image")) {
                $file = $request->file("variants.$index.image");
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/variants'), $imageName);
                $variantPayload['image'] = $imageName;
            }

            if ($variantId) {
                $variant = ProductVariant::where('id', $variantId)->where('product_id', $product->id)->first();
                if ($variant) {
                    $variant->update($variantPayload);
                } else {
                    $variant = ProductVariant::create($variantPayload);
                }
            } else {
                $variant = ProductVariant::create($variantPayload);
            }

            $submittedVariantIds[] = $variant->id;

            // Sync Sizes
            $submittedSizeIds = [];
            foreach ($variantData['sizes'] ?? [] as $sizeData) {
                // Check if size is enabled (checkbox was checked, so it's in the array)
                // Wait, if it's sent in the array, we process it.
                $size = Size::forSeller($sellerId)->find($sizeData['size_id']);
                if (!$size) continue;

                VariantSize::updateOrCreate(
                    ['variant_id' => $variant->id, 'size_id' => $sizeData['size_id']],
                    [
                        'price' => $sizeData['price'],
                        'original_price' => $sizeData['original_price'] ?? null,
                        'quantity' => $sizeData['quantity'],
                    ]
                );
                $submittedSizeIds[] = $sizeData['size_id'];
            }

            // Delete sizes that were unchecked
            VariantSize::where('variant_id', $variant->id)
                       ->whereNotIn('size_id', $submittedSizeIds)
                       ->delete();
        }

        // We don't delete missing variants automatically here unless requested.
        // Wait, if we are editing all variants inline, missing variants were deleted?
        // Let's rely on the separate delete route for deleting variants, it's safer.

        return redirect()->route('seller.variants.index', $product->id)->with('success', 'Variants saved successfully.');
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
