<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Homepage logic
    public function index()
    {
        // Yahan se 'take(6)' hata diya gaya hai. 
        // Ab admin panel mein jitni bhi 'Active' categories hongi, wo sab directly Search dropdown mein show hongi.
        $categories = Category::where('is_active', true)->get();
        
        // Products 8 hi show karenge taake homepage par zyada load na ho
        $products = Product::with('category')->latest()->take(8)->get();
        
        return view('frontend.home', compact('categories', 'products'));
    }

    // Single Product Details Page logic
    public function show($slug)
    {
        // URL slug ke zariye product aur uske reviews fetch karein
        $product = Product::with(['category', 'reviews.user'])->where('slug', $slug)->firstOrFail();
        
        // Related products (Same category ki dusri products)
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->latest()
                                  ->take(4)
                                  ->get();
                                  
        return view('frontend.product-details', compact('product', 'relatedProducts'));
    }
// Live AJAX Search Logic
    public function ajaxSearch(\Illuminate\Http\Request $request)
    {
        $query = $request->input('q');
        
        $products = \App\Models\Product::with('category')
                           ->where('name', 'LIKE', "%{$query}%")
                           ->orWhere('sku', 'LIKE', "%{$query}%")
                           ->take(5) // Dropdown mein sirf top 5 results
                           ->get(['id', 'name', 'slug', 'price', 'image']);
                           
        return response()->json($products);
    }
}