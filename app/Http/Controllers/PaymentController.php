<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function process(Order $order)
    {
        if ($order->payment_status !== 'pending') {
            return redirect()->route('orders.show', $order);
        }

        // PayTR için gerekli parametreler
        $merchant_id = config('services.paytr.merchant_id');
        $merchant_key = config('services.paytr.merchant_key');
        $merchant_salt = config('services.paytr.merchant_salt');

        $email = $order->billing_email;
        $payment_amount = $order->total_amount * 100; // PayTR kuruş cinsinden istiyor
        $merchant_oid = $order->order_number;
        $user_name = $order->billing_name;
        $user_address = $order->billing_address;
        $user_phone = $order->billing_phone;
        $merchant_ok_url = route('payment.success');
        $merchant_fail_url = route('payment.cancel');
        $user_basket = [];

        foreach ($order->items as $item) {
            $user_basket[] = [$item->product->name, $item->price, $item->quantity];
        }

        // Token oluşturma
        $hash_str = $merchant_id . $email . $merchant_oid . $payment_amount . $merchant_ok_url . $merchant_fail_url . 'card';
        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));

        $post_vals = [
            'merchant_id' => $merchant_id,
            'user_ip' => request()->ip(),
            'merchant_oid' => $merchant_oid,
            'email' => $email,
            'payment_amount' => $payment_amount,
            'paytr_token' => $paytr_token,
            'user_basket' => base64_encode(json_encode($user_basket)),
            'debug_on' => 1,
            'no_installment' => 0,
            'max_installment' => 0,
            'user_name' => $user_name,
            'user_address' => $user_address,
            'user_phone' => $user_phone,
            'merchant_ok_url' => $merchant_ok_url,
            'merchant_fail_url' => $merchant_fail_url,
            'timeout_limit' => 30,
            'currency' => 'TL',
            'test_mode' => config('services.paytr.test_mode', 1)
        ];

        // PayTR'ye istek gönderme
        $response = Http::post('https://www.paytr.com/odeme/api/get-token', $post_vals);
        $result = $response->json();

        if ($result['status'] === 'success') {
            return view('payment.iframe', [
                'token' => $result['token'],
                'order' => $order
            ]);
        }

        return redirect()->route('orders.show', $order)
            ->with('error', 'Ödeme işlemi başlatılamadı. Lütfen daha sonra tekrar deneyin.');
    }

    public function success(Request $request)
    {
        $order = Order::where('order_number', $request->merchant_oid)->firstOrFail();
        
        if ($this->verifyHash($request)) {
            $order->update([
                'payment_status' => 'completed',
                'status' => 'processing'
            ]);

            return redirect()->route('orders.show', $order)
                ->with('success', 'Ödemeniz başarıyla alındı.');
        }

        return redirect()->route('orders.show', $order)
            ->with('error', 'Ödeme doğrulaması başarısız oldu.');
    }

    public function cancel(Request $request)
    {
        $order = Order::where('order_number', $request->merchant_oid)->firstOrFail();
        
        $order->update([
            'payment_status' => 'failed',
            'status' => 'cancelled'
        ]);

        return redirect()->route('orders.show', $order)
            ->with('error', 'Ödeme işlemi iptal edildi.');
    }

    protected function verifyHash(Request $request)
    {
        $merchant_key = config('services.paytr.merchant_key');
        $merchant_salt = config('services.paytr.merchant_salt');
        
        $hash = base64_encode(hash_hmac('sha256', $request->merchant_oid . $merchant_salt . $request->status . $request->total_amount, $merchant_key, true));
        
        return $hash === $request->hash;
    }
}
