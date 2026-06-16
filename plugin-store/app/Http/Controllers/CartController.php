<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Coupon; // <-- Yeh add karein
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        
        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Coupon calculation
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

        return view('frontend.cart', compact('cart', 'subtotal', 'discount', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $requestedQuantity = $request->input('quantity', 1);

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $requestedQuantity;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $requestedQuantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            // Agar cart khali ho jaye toh coupon bhi remove kar dein
            if(empty($cart)) {
                session()->forget('coupon');
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    // New: Apply Coupon
       public function applyCoupon(\Illuminate\Http\Request $request)
               {
        // 1. Pehle check karein ke input mein kuch aaya bhi hai ya nahi
        $request->validate([
            'code' => 'required|string'
        ]);

        // 2. Database mein search karein (strtoupper se small/capital letters ka masla khatam ho jayega)
        $coupon = \App\Models\Coupon::where('code', strtoupper($request->code))
                                    ->where('is_active', true)
                                    ->first();
        
        // 3. Agar coupon na mile toh error return karein
        if(!$coupon) {
            return back()->with('error', 'Invalid or expired coupon code!');
        }

        // 4. Agar mil jaye toh session mein save kar lein
        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value
        ]);

        return back()->with('success', 'Coupon applied successfully!');
    }

    // New: Remove Coupon
    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Coupon removed successfully.');
    }
}