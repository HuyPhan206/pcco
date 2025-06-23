<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order; // Corrected namespace
use App\Models\OrderItem; // Corrected namespace
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $cart = session()->get('cart', []);

    // Lấy và xử lý giá trị price
    $price = $product->discount_price ?? $product->price;
    $price = floatval(str_replace(',', '', $price)); // Loại bỏ dấu phẩy và chuyển thành số

    // Kiểm tra phạm vi
    if ($price <= 0 || $price > 999999999999.99) {
        return redirect()->back()->with('error', 'Giá sản phẩm không hợp lệ hoặc vượt quá giới hạn (tối đa 999,999,999,999.99).');
    }

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => number_format($price, 2, '.', ''), // Định dạng 2 chữ số thập phân
            'image' => $product->image,
        ];
    }

    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
}   

   

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $quantity = $request->input('quantity', 1);
            if ($quantity > 0) {
                $cart[$id]['quantity'] = $quantity;
                session()->put('cart', $cart);
            }
        }
        return redirect()->back()->with('success', 'Đã cập nhật số lượng!');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = new Order;
        $order->user_id = $user->id;
        $order->order_number = 'ORD-' . Str::random(6);
        $order->total = $total;
        $order->status = 'pending';
        $order->save();

        foreach ($cart as $id => $item) {
            $orderItem = new OrderItem;
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $id;
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $item['price'];
            $orderItem->save();
        }

        session()->forget('cart');
        return redirect()->route('orders.index')->with('success', 'Đặt hàng thành công!');
    }
}