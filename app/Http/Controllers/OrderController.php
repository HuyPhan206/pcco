<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->get();
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->with('items.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        if ($order->status == 'pending') {
            $order->status = 'canceled';
            $order->canceled_date = now(); // Line 34: This causes the error because 'canceled_date' column is missing
            $order->save();
            return redirect()->route('orders.index')->with('success', 'Đã hủy đơn hàng!');
        }
        return redirect()->route('orders.index')->with('error', 'Không thể hủy đơn hàng này!');
    }
    public function store(Request $request)
    {
        $cart = session('cart');
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $total,
        ]);
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
        session()->forget('cart');
        return redirect('/')->with('success', 'Đặt hàng thành công!');
    }
    
}