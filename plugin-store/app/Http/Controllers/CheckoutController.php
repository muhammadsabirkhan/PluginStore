<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('home')->with('success', 'Your cart is empty. Please add some products first.');
        }

        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        if (session()->has('coupon')) {
            $coupon = session('coupon');
            if ($coupon['type'] == 'percent') {
                $discount = ($subtotal * $coupon['value']) / 100;
            } else {
                $discount = $coupon['value'];
            }
        }

        $total = $subtotal - $discount;

        return view('frontend.checkout', compact('cart', 'subtotal', 'discount', 'total'));
    }

   public function process(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string',
            'payment_method' => 'required|in:cod,stripe'
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home');
        }

    
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        if (session()->has('coupon')) {
            $coupon = session('coupon');
            $discount = $coupon['type'] == 'percent' ? ($total * $coupon['value']) / 100 : $coupon['value'];
            $total -= $discount;
        }


        if ($request->payment_method === 'cod') {
            $this->saveOrder($request, $total, 'pending');
            session()->forget(['cart', 'coupon']);
            return redirect()->route('home')->with('success', 'Your COD Order has been placed successfully.');
        }

        if ($request->payment_method === 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            session()->put('checkout_details', $request->all());
            session()->put('checkout_total', $total);

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'pkr',
                        'product_data' => [
                            'name' => 'PlugIn Store Order',
                        ],
                        'unit_amount' => $total * 100, 
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('checkout.success'),
                'cancel_url' => route('checkout.cancel'),
            ]);

            return redirect($session->url);
        }
    }

    private function saveOrder($request, $totalAmount, $paymentStatus)
    {
        $order = Order::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'full_name' => $request->full_name ?? $request['full_name'],
            'email' => $request->email ?? $request['email'],
            'phone' => $request->phone ?? $request['phone'],
            'shipping_address' => $request->shipping_address ?? $request['shipping_address'],
            'city' => $request->city ?? $request['city'],
            'total_amount' => $totalAmount,
            'payment_method' => $request->payment_method ?? $request['payment_method'],
            'payment_status' => $paymentStatus,
            'order_status' => 'processing',
        ]);

        $cart = session()->get('cart', []);
        foreach($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
        return $order;
    }

    public function success()
    {
        if(session()->has('checkout_details')) {
            $details = session()->get('checkout_details');
            $total = session()->get('checkout_total');
            
            $order = $this->saveOrder($details, $total, 'paid');
            
            session()->forget(['cart', 'coupon', 'checkout_details', 'checkout_total']);
            return redirect()->route('home')->with('success', 'Payment Successful! Your Order #'.$order->id.' has been placed.');
        }
        return redirect()->route('home');
    }

    public function cancel()
    {
        return redirect()->route('checkout.index')->with('error', 'Payment was cancelled. Please try again.');
    }
}