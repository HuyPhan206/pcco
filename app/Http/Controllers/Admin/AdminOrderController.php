<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    
    public function edit($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,canceled']);
        
        $order->status = $request->status;
        
        if ($order->status == 'delivered') {
            $order->delivered_date = now();
        } elseif ($order->status == 'canceled') {
            $order->canceled_date = now();
        }
        
        $order->save();
        
        return redirect()->route('admin.orders.show', $id)->with('success', 'Cập nhật đơn hàng thành công!');
    }

    public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $request->validate(['status' => 'required|in:pending,delivered,canceled']);
    $order->status = $request->status;
    if ($order->status == 'delivered') {
        $order->delivered_date = now();
    } elseif ($order->status == 'canceled') {
        $order->canceled_date = now(); // This line causes the error if the column is missing
    }
    $order->save();
    return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái thành công!');
}
}