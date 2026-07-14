<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with(['order.user', 'product'])
            ->where('seller_id', Auth::guard('seller')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('seller.orders.index', compact('orderItems'));
    }

    public function show($id)
    {
        $orderItem = OrderItem::with(['order.user', 'product'])
            ->where('seller_id', Auth::guard('seller')->id())
            ->findOrFail($id);
            
        return view('seller.orders.show', compact('orderItem'));
    }
}
