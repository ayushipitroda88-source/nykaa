<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerManagementController extends Controller
{
    public function index()
    {
        $sellers = Seller::all();
        return view('admin.sellers.index', compact('sellers'));
    }

    public function show($id)
    {
        $seller = Seller::findOrFail($id);
        return view('admin.sellers.show', compact('seller'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,suspended'
        ]);

        $seller = Seller::findOrFail($id);
        $seller->status = $request->status;
        $seller->save();

        return redirect()->back()->with('success', "Seller status updated to {$request->status}");
    }
}
