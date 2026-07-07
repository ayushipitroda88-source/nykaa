<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->get();
        return view('color', compact('colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'required|string|max:20',
            'status' => 'required|in:0,1',
        ]);

        Color::create([
            'name' => $request->name,
            'color_code' => $request->color_code,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Color Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'required|string|max:20',
            'status' => 'required|in:0,1',
        ]);

        $color = Color::findOrFail($id);
        $color->update([
            'name' => $request->name,
            'color_code' => $request->color_code,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Color Updated Successfully');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return back()->with('success', 'Color Deleted Successfully');
    }
}
