<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    /**
     * Admin: View all seller colors.
     * Admin cannot create or edit colors, only view and optionally delete.
     */
    public function index()
    {
        $colors = Color::with('seller')->latest()->get();
        return view('admin.colors.index', compact('colors'));
    }

    /**
     * Redirect: Admin cannot create colors.
     * Route kept for backward compatibility.
     */
    public function store(Request $request)
    {
        return redirect()->route('color.index')
            ->with('error', 'Admin cannot create colors. Sellers manage their own colors.');
    }

    /**
     * Redirect: Admin cannot edit colors.
     * Route kept for backward compatibility.
     */
    public function update(Request $request, $id)
    {
        return redirect()->route('color.index')
            ->with('error', 'Admin cannot edit colors. Sellers manage their own colors.');
    }

    /**
     * Admin may optionally delete inappropriate records.
     */
    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return back()->with('success', 'Color deleted successfully.');
    }
}
