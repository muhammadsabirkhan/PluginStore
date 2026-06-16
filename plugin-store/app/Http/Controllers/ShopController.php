<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('sort')) {
            if ($request->sort == 'low_high') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'high_low') {
                $query->orderBy('price', 'desc');
            }
        } else {
            $query->latest(); 
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $pageTitle = "Shop All Products";

        return view('frontend.shop', compact('products', 'categories', 'pageTitle'));
    }

    public function newArrivals()
    {
        $products = Product::with('category')->latest()->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $pageTitle = "New Arrivals";
        
        return view('frontend.shop', compact('products', 'categories', 'pageTitle'));
    }

    public function deals()
    {
        $products = Product::with('category')->whereNotNull('discount_price')->where('discount_price', '>', 0)->latest()->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $pageTitle = "Exclusive Deals";
        
        return view('frontend.shop', compact('products', 'categories', 'pageTitle'));
    }
}