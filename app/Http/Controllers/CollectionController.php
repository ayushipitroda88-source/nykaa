<?php

namespace App\Http\Controllers;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::all();

        return view('collections.index', compact('collections'));
    }
        
    public function store(Request $request)
{
    $imageName = null;

    if ($request->hasFile('image')) {

        $imageName = time() . '.' . $request->image->extension();

        $request->image->move(
            public_path('uploads/collections'),
            $imageName
        );
    }

    $collection = Collection::create([
    'name'             => $request->name,
    'slug'             => Str::slug($request->name),
    'description'      => $request->description,
    'image'            => $imageName,
    'status'           => $request->status ?? 1,

    'discount'         => $request->discount,
    'discount_start'   => $request->discount_start,
    'discount_end'     => $request->discount_end,
]);

    $collection->products()->attach($request->products ?? []);

    return redirect()
            ->route('collections.index')
            ->with('success', 'Collection Created Successfully');
}
   
public function update(Request $request, $id)
{
    $collection = Collection::findOrFail($id);

    $data = [
    'name'             => $request->name,
    'discount'         => $request->discount,
    'discount_start'   => $request->discount_start,
    'discount_end'     => $request->discount_end,
];

    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(
            public_path('uploads/collections'),
            $imageName
        );
        $data['image'] = $imageName;
    }

    $collection->update($data);

    return redirect()->back()->with('success', 'Collection Updated Successfully');
}
    public function destroy(Collection $collection)
{
    $collection->delete();

    return redirect()->back()
                     ->with('success', 'Collection deleted successfully');
}

public function userIndex()
{
    $collections = Collection::where('status', 1)
                    ->latest()
                    ->get();

    return view('user.collections', compact('collections'));
}

public function userShow($id)
{
    $collection = Collection::with('products.category')
                    ->findOrFail($id);

    return view('user.collection-products', compact('collection'));
}
}
