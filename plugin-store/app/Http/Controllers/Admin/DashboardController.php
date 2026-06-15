<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats for the dashboard
        $stats = [
            'total_categories' => Category::count(),
            'total_products' => Product::count(),
            'total_users' => User::where('role', 'customer')->count(),
            // Order logic hum Module 3 ke baad add karenge
            'total_orders' => 0, 
        ];

        return view('admin.dashboard', compact('stats'));
    }
}