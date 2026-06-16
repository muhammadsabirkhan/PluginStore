<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  
    public function index()
    {

        $categories = Category::where('is_active', true)->get();
        
        $products = Product::with('category')->latest()->take(8)->get();
        
        return view('frontend.home', compact('categories', 'products'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'reviews.user'])->where('slug', $slug)->firstOrFail();
        
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->latest()
                                  ->take(4)
                                  ->get();
                                  
        return view('frontend.product-details', compact('product', 'relatedProducts'));
    }

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