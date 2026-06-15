<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist - PlugIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="bg-white border-b border-gray-100 p-4 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">PlugIn<span class="text-blue-600">.</span></h1>
            </a>
            <div class="flex items-center gap-6">
                <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-gray-600 hover:text-blue-600">Shop</a>
                <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-blue-600 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ count((array) session('cart')) }}</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-10 flex flex-col md:flex-row gap-8">
        
        <aside class="w-full md:w-1/4">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                <nav class="space-y-2">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-blue-600 rounded-lg font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        My Orders
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-3 bg-red-50 text-red-600 rounded-lg font-medium transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        My Wishlist
                    </a>
                </nav>
            </div>
        </aside>

        <section class="w-full md:w-3/4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Saved Items (❤️)</h2>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg font-medium shadow-sm">{{ session('success') }}</div>
                @endif

                @if($wishlists->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($wishlists as $item)
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 flex flex-col relative">
                            
                            <form action="{{ route('wishlist.toggle', $item->product->id) }}" method="POST" class="absolute top-2 right-2 z-10">
                                @csrf
                                <button type="submit" class="bg-white p-2 rounded-full shadow hover:text-red-500 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </form>

                            <a href="{{ route('product.show', $item->product->slug) }}" class="rounded-xl aspect-square mb-4 flex items-center justify-center p-4">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-contain mix-blend-multiply">
                                @endif
                            </a>
                            <div class="space-y-1 mt-auto">
                                <h4 class="text-base font-bold text-gray-900 leading-tight line-clamp-1">{{ $item->product->name }}</h4>
                                <p class="text-lg font-extrabold text-blue-600 mb-4">Rs. {{ number_format($item->product->price) }}</p>
                                
                                <form action="{{ route('cart.add', $item->product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-gray-900 text-white font-bold py-2 rounded-lg hover:bg-gray-800 transition shadow-md">
                                        Move to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 border-2 border-dashed border-gray-100 rounded-xl">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Your wishlist is empty</h3>
                        <p class="text-gray-500 mb-6">Save your favorite products here to buy them later.</p>
                        <a href="{{ route('shop.index') }}" class="inline-block bg-blue-600 text-white font-semibold px-6 py-2.5 rounded-full hover:bg-blue-700 transition">Explore Products</a>
                    </div>
                @endif
            </div>
        </section>

    </main>
</body>
</html>