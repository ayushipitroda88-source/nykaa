<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    /**
     * Admin: View all seller sizes.
     * Admin cannot create or edit sizes, only view and optionally delete.
     */
    public function index()
    {
        $sizes = Size::with('seller')->latest()->get();
        return view('admin.sizes.index', compact('sizes'));
    }

    /**
     * Redirect: Admin cannot create sizes.
     * Route kept for backward compatibility.
     */
    public function store(Request $request)
    {
        return redirect()->route('size.index')
            ->with('error', 'Admin cannot create sizes. Sellers manage their own sizes.');
    }

    /**
     * Redirect: Admin cannot edit sizes.
     * Route kept for backward compatibility.
     */
    public function update(Request $request, $id)
    {
        return redirect()->route('size.index')
            ->with('error', 'Admin cannot edit sizes. Sellers manage their own sizes.');
    }

    /**
     * Admin may optionally delete inappropriate records.
     */
    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return back()->with('success', 'Size deleted successfully.');
    }
}
