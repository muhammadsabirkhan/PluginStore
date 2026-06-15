<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // 1. Shop All (With Search & Filters)
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search Filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Sorting
        if ($request->filled('sort')) {
            if ($request->sort == 'low_high') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'high_low') {
                $query->orderBy('price', 'desc');
            }
        } else {
            $query->latest(); // Default sorting
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $pageTitle = "Shop All Products";

        return view('frontend.shop', compact('products', 'categories', 'pageTitle'));
    }

    // 2. New Arrivals
    public function newArrivals()
    {
        // Sab se latest products
        $products = Product::with('category')->latest()->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $pageTitle = "New Arrivals";
        
        return view('frontend.shop', compact('products', 'categories', 'pageTitle'));
    }

    // 3. Deals (Discounted Products)
    public function deals()
    {
        // Wo products jinpar discount laga hua hai
        $products = Product::with('category')->whereNotNull('discount_price')->where('discount_price', '>', 0)->latest()->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $pageTitle = "Exclusive Deals";
        
        return view('frontend.shop', compact('products', 'categories', 'pageTitle'));
    }
}