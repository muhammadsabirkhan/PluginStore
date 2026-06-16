<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['order_status' => 'required|in:pending,processing,shipped,delivered']);
        
        $order = Order::findOrFail($id);
        $order->update(['order_status' => $request->order_status]);

        return back()->with('success', 'Order #' . $order->id . ' status updated to ' . ucfirst($request->order_status));
    }
}