<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    /**
     * Display a listing of the customer's orders.
     */
    public function index()
    {
        $orders = Order::with(['items.product.variants', 'items.product.reviews' => function ($q) {
            $q->where('user_id', Auth::id());
        }])
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    /**
     * Display details of a specific order.
     */
    public function show($id)
    {
        $order = Order::with(['items.product', 'items.product.reviews' => function ($q) {
            $q->where('user_id', Auth::id());
        }])
        ->where('user_id', Auth::id())
        ->findOrFail($id);

        return view('user.orders.show', compact('order'));
    }

    /**
     * Confirm order receipt.
     * Updates Order status to 'confirmed'.
     */
    public function confirmOrder(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if (!in_array(strtolower($order->status), ['confirmed', 'cancelled'])) {
            $order->status = 'confirmed';
            $order->confirmed_at = now();
            $order->save();
        }

        return redirect()->back()->with('success', 'Order confirmed successfully! You can now rate and review your ordered products.');
    }
}
