<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout - PlugIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="bg-white border-b border-gray-100 p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">PlugIn<span class="text-blue-600">.</span></h1>
            </a>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('cart.index') }}" class="text-sm font-semibold text-gray-600 hover:text-blue-600">&larr; Back to Cart</a>
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0">
                        @csrf
                        <button type="submit" class="text-sm font-semibold bg-red-50 text-red-600 border border-red-100 px-5 py-2 rounded-full hover:bg-red-100 transition shadow-sm">
                            Log out
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-12">
        
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg font-medium shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-2/3">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Delivery Details</h2>
                
                <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="full_name" required value="{{ Auth::check() ? Auth::user()->name : '' }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition">
                            @error('full_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" required value="{{ Auth::check() ? Auth::user()->email : '' }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition">
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="text" name="phone" required value="{{ Auth::check() ? Auth::user()->phone : '' }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition">
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                            <input type="text" name="city" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition">
                            @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Complete Shipping Address</label>
                        <textarea name="shipping_address" required rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition"></textarea>
                        @error('shipping_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Method</h3>
                    <div class="space-y-3 mb-8">
                        
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="payment_method" value="cod" checked class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <span class="ml-3 font-medium text-gray-900">Cash on Delivery (COD)</span>
                        </label>
                        
                        <label class="flex items-center p-4 border border-blue-100 bg-blue-50/30 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                            <input type="radio" name="payment_method" value="stripe" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3 flex-1 flex justify-between items-center">
                                <span class="font-medium text-gray-900">Pay with Credit/Debit Card</span>
                                <div class="flex gap-1">
                                    <svg class="w-8 h-6 text-blue-600" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
                                </div>
                            </div>
                        </label>

                    </div>

                    <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition shadow-lg transform hover:-translate-y-0.5">
                        Place Order (Rs. {{ number_format($total) }})
                    </button>
                </form>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Your Order</h3>
                    
                    <div class="space-y-4 mb-6 max-h-64 overflow-y-auto pr-2">
                        @foreach($cart as $details)
                        <div class="flex gap-4 items-center">
                            @if($details['image'])
                                <img src="{{ asset('storage/' . $details['image']) }}" class="w-12 h-12 rounded object-cover border">
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded"></div>
                            @endif
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-900 line-clamp-1">{{ $details['name'] }}</h4>
                                <p class="text-xs text-gray-500">Qty: {{ $details['quantity'] }}</p>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">Rs. {{ number_format($details['price'] * $details['quantity']) }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-3 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-900">Rs. {{ number_format($subtotal) }}</span>
                        </div>

                        @if(session()->has('coupon'))
                        <div class="flex justify-between text-green-600">
                            <span>Discount ({{ session('coupon')['code'] }})</span>
                            <span class="font-bold">- Rs. {{ number_format($discount) }}</span>
                        </div>
                        @endif

                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span class="text-green-600 font-medium">Free</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-4 mt-4 flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900">Total</span>
                        <span class="text-2xl font-extrabold text-blue-600">Rs. {{ number_format($total) }}</span>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>