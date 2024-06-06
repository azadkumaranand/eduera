<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('payment-form');
    }

    public function createOrder(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $order = $api->order->create([
            'receipt' => uniqid(),
            'amount' => 50000, // Amount in paise (50000 paise = INR 500)
            'currency' => 'INR',
            'payment_capture' => 1 // Auto capture
        ]);

        return response()->json($order);
    }

    public function paymentSuccess(Request $request)
    {
        $signatureStatus = $this->verifySignature(
            $request->razorpay_signature,
            $request->razorpay_payment_id,
            $request->razorpay_order_id
        );

        if ($signatureStatus) {
            // Payment was successful, you can process the order and update your database
            return view('checkout-success');
        } else {
            // Payment verification failed
            return view('checkout-cancel');
        }
    }

    private function verifySignature($signature, $paymentId, $orderId)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $attributes = [
            'razorpay_signature' => $signature,
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => $orderId
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
