<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'shipping_name' => 'required|string|max:255',
        'shipping_address' => 'required|string|max:500',
        'shipping_phone' => 'required|regex:/^0[0-9]{9,10}$/',
        'payment_method' => 'required|in:cash_on_delivery,momo,zalopay',
    ]);

    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->back()->withErrors(['cart' => 'Giỏ hàng trống.']);
    }

    $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
    $user = Auth::user();
    $orderNumber = 'ORD-' . Str::random(10);

    $order = Order::create([
        'user_id' => $user->id,
        'order_number' => $orderNumber,
        'total' => $total,
        'status' => 'pending',
    ]);

    foreach ($cart as $item) {
        if (!isset($item['id']) || empty($item['id'])) {
            $order->update(['status' => 'failed', 'canceled_date' => now()]);
            return redirect()->back()->withErrors(['cart' => 'Sản phẩm trong giỏ hàng thiếu thông tin ID.']);
        }
        $price = floatval($item['price']);
        if ($price <= 0 || $price > 999999999999.99) {
            $order->update(['status' => 'failed', 'canceled_date' => now()]);
            return redirect()->back()->withErrors(['cart' => 'Giá sản phẩm không hợp lệ hoặc vượt quá giới hạn.']);
        }
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['id'],
            'quantity' => $item['quantity'],
            'price' => number_format($price, 2, '.', ''),
        ]);
    }

        if ($request->payment_method === 'cash_on_delivery') {
            $order->update(['status' => 'completed']);
            session()->forget('cart');
            return redirect()->route('cart.index')->with('success', 'Đặt hàng thành công!');
        } elseif ($request->payment_method === 'momo') {
            $endpoint = 'https://test-payment.momo.vn/v2/gateway/api/create';
            $partnerCode = 'MOMO'; // Thay bằng Partner Code của bạn
            $accessKey = 'your_access_key'; // Thay bằng Access Key
            $secretKey = 'your_secret_key'; // Thay bằng Secret Key
            $requestId = time();
            $amount = $total;
            $orderInfo = 'Thanh toán đơn hàng từ giỏ hàng';
            $returnUrl = route('checkout.callback');
            $notifyUrl = route('checkout.notify');

            $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderNumber . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "¬ifyUrl=" . $notifyUrl . "&extraData=";

            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $response = Http::post($endpoint, [
                'partnerCode' => $partnerCode,
                'accessKey' => $accessKey,
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderNumber,
                'orderInfo' => $orderInfo,
                'returnUrl' => $returnUrl,
                'notifyUrl' => $notifyUrl,
                'extraData' => '',
                'requestType' => 'captureMoMoWallet',
                'signature' => $signature,
            ]);

            $result = $response->json();

            if ($result['resultCode'] == 0) {
                return redirect($result['payUrl']);
            } else {
                $order->update(['status' => 'failed', 'canceled_date' => now()]);
                return redirect()->back()->withErrors(['payment' => 'Lỗi khi tạo thanh toán MoMo: ' . $result['message']]);
            }
        } elseif ($request->payment_method === 'zalopay') {
            $endpoint = 'https://sb-openapi.zalopay.vn/v2/create';
            $appId = 'your_app_id'; // Thay bằng App ID của ZaloPay
            $key1 = 'your_key_1'; // Thay bằng Key 1
            $appTransId = 'ZALO-' . time();
            $amount = $total;
            $appTime = time() * 1000; // Thời gian mili giây
            $embedData = '{}';
            $item = json_encode(['id' => $orderNumber, 'total' => $total]);
            $description = 'Thanh toán đơn hàng từ giỏ hàng';
            $callbackUrl = route('checkout.callback');
            $mac = hash_hmac('sha256', implode('', [$appId, $appTransId, $appTime, $amount, $item, $description, $callbackUrl]), $key1);

            $response = Http::post($endpoint, [
                'app_id' => $appId,
                'app_trans_id' => $appTransId,
                'app_time' => $appTime,
                'amount' => $amount,
                'embed_data' => $embedData,
                'item' => $item,
                'description' => $description,
                'callback_url' => $callbackUrl,
                'mac' => $mac,
            ]);

            $result = $response->json();

            if ($result['return_code'] == 1) {
                return redirect('zalopay://payment?' . http_build_query(['app_id' => $appId, 'zp_trans_token' => $result['zp_trans_token']]));
            } else {
                $order->update(['status' => 'failed', 'canceled_date' => now()]);
                return redirect()->back()->withErrors(['payment' => 'Lỗi khi tạo thanh toán ZaloPay: ' . $result['return_message']]);
            }
        }
    }

    public function callback(Request $request)
    {
        $orderNumber = $request->has('orderId') ? $request->orderId : $request->app_trans_id;
        $resultCode = $request->has('resultCode') ? $request->resultCode : $request->return_code;

        $order = Order::where('order_number', $orderNumber)->first();
        Log::info('Callback Data: ', ['order_number' => $orderNumber, 'resultCode' => $resultCode, 'order' => $order]);

        if (!$order) {
            Log::warning('Order not found: ' . $orderNumber);
            return redirect()->route('checkout.index')->withErrors(['payment' => 'Đơn hàng không tồn tại.']);
        }

        if ($resultCode == 0 || $resultCode == 1) { // Thành công
            $order->update(['status' => 'completed']);
            session()->forget('cart');
            Log::info('Order Completed: ' . $orderNumber);
            return redirect()->route('cart.index')->with('success', 'Thanh toán thành công!');
        } else { // Thất bại
            $order->update(['status' => 'failed', 'canceled_date' => now()]);
            Log::warning('Order Failed: ' . $orderNumber . ', Result Code: ' . $resultCode);
            return redirect()->route('checkout.index')->withErrors(['payment' => 'Thanh toán thất bại.']);
        }
    }

    public function notify(Request $request)
    {
        $orderNumber = $request->has('orderId') ? $request->orderId : $request->app_trans_id;
        $resultCode = $request->has('resultCode') ? $request->resultCode : $request->return_code;

        $order = Order::where('order_number', $orderNumber)->first();
        Log::info('Notify Data: ', ['order_number' => $orderNumber, 'resultCode' => $resultCode, 'order' => $order]);

        if ($order && ($resultCode == 0 || $resultCode == 1)) {
            $order->update(['status' => 'completed']);
            Log::info('Order Confirmed via Notify: ' . $orderNumber);
        }
    }
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->input('status')]);
        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}