<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('admin.orders.index', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->input('status'),
        ]);
        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật đơn hàng thành công!');
    }
}