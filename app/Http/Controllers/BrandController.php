<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    // LIST PAGE
    public function index()
    {
        $brands = Brand::latest()->get();
        return view('brand', compact('brands'));
    }

    // STORE
    public function store(Request $request)
    {
        $brand = new Brand();

        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->description = $request->description;
        $brand->status = $request->status;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/brands'), $filename);
            $brand->logo = $filename;
        }

        $brand->save();

        return back()->with('success','Brand Added');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->description = $request->description;
        $brand->status = $request->status;

        $brand->save();

        return back()->with('success','Brand Updated');
    }

    // DELETE
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return back()->with('success','Brand Deleted');
    }
}   