<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Show Wishlist Page
    public function index()
    {
        $wishlists = Wishlist::with('product')->where('user_id', Auth::id())->latest()->get();
        return view('frontend.user.wishlist', compact('wishlists'));
    }

    // Add or Remove from Wishlist (Toggle)
    public function toggle($productId)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Product removed from your Wishlist.');
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId
            ]);
            return back()->with('success', 'Product added to your Wishlist ❤️');
        }
    }
}