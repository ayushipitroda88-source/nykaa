<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::latest()->get();
        return view('size', compact('sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        Size::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Size Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $size = Size::findOrFail($id);
        $size->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Size Updated Successfully');
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return back()->with('success', 'Size Deleted Successfully');
    }
}
