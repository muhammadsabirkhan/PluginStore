<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        
        return view('frontend.user.dashboard', compact('orders'));
    }
}