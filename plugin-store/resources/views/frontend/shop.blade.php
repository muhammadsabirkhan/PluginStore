<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} - PlugIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; overflow-x: hidden; }</style>
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

            <div class="hidden md:flex gap-8 font-medium text-sm text-gray-600">
                <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.index') ? 'text-blue-600 font-bold' : 'hover:text-blue-600 transition' }}">Shop All</a>
                <a href="{{ route('shop.new_arrivals') }}" class="{{ request()->routeIs('shop.new_arrivals') ? 'text-blue-600 font-bold' : 'hover:text-blue-600 transition' }}">New Arrivals</a>
                <a href="{{ route('shop.deals') }}" class="{{ request()->routeIs('shop.deals') ? 'text-blue-600 font-bold' : 'hover:text-blue-600 transition' }}">Deals</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-blue-600 transition relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                        {{ count((array) session('cart')) }}
                    </span>
                </a>

                @auth
                    <a href="{{ route('user.dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-blue-600 transition ml-4">My Account</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold bg-blue-600 text-white px-5 py-2 rounded-full hover:bg-blue-700 transition ml-4">Log in</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="bg-white border-b border-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-8">
            <h1 class="text-4xl font-extrabold text-gray-900">{{ $pageTitle }}</h1>
            <p class="text-gray-500 mt-2">Find the best electronics and smart gadgets.</p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-10 flex flex-col md:flex-row gap-8">
        
        <aside class="w-full md:w-1/4">
            <form action="{{ route('shop.index') }}" method="GET" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                
                <h3 class="font-bold text-gray-900 mb-4">Search</h3>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full px-4 py-2 border border-gray-200 rounded-lg mb-6 focus:ring-2 focus:ring-blue-500 outline-none">
                
                <h3 class="font-bold text-gray-900 mb-4">Categories</h3>
                <div class="space-y-2 mb-6 max-h-48 overflow-y-auto">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="category" value="" {{ request('category') == '' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">All Categories</span>
                    </label>
                    @foreach($categories as $cat)
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="category" value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">{{ $cat->name }}</span>
                    </label>
                    @endforeach
                </div>

                <h3 class="font-bold text-gray-900 mb-4">Sort By Price</h3>
                <select name="sort" class="w-full px-4 py-2 border border-gray-200 rounded-lg mb-6 focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                    <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>Price: High to Low</option>
                </select>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2.5 rounded-lg hover:bg-blue-700 transition">Apply Filters</button>
                @if(request()->hasAny(['search', 'category', 'sort']))
                    <a href="{{ route('shop.index') }}" class="w-full block text-center mt-3 text-sm text-gray-500 hover:text-red-500 transition">Clear Filters</a>
                @endif
            </form>
        </aside>

        <section class="w-full md:w-3/4">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg font-medium shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                <div class="bg-white rounded-2xl p-4 border border-gray-100 group flex flex-col hover:-translate-y-1 hover:shadow-xl transition duration-300 relative">
                    
                    @auth
                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="absolute top-6 right-6 z-10">
                        @csrf
                        <button type="submit" class="p-2 bg-white/90 backdrop-blur text-gray-400 hover:text-red-500 rounded-full transition shadow-sm border border-gray-100 hover:border-red-100" title="Toggle Wishlist">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                    </form>
                    @endauth
                    <a href="{{ route('product.show', $product->slug) }}" class="relative bg-gray-50 rounded-xl aspect-square mb-4 overflow-hidden flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="object-contain w-full h-full mix-blend-multiply group-hover:scale-110 transition duration-500">
                        @else
                            <span class="text-gray-400">No Image</span>
                        @endif
                        @if($product->discount_price)
                            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">Sale</span>
                        @endif
                    </a>
                    <div class="space-y-1 mt-auto">
                        <p class="text-xs font-semibold text-blue-600 uppercase">{{ $product->category->name }}</p>
                        <a href="{{ route('product.show', $product->slug) }}">
                            <h4 class="text-lg font-bold text-gray-900 leading-tight line-clamp-1 hover:text-blue-600 transition">{{ $product->name }}</h4>
                        </a>
                        <div class="flex items-center gap-2 pt-2">
                            <p class="text-xl font-extrabold text-gray-900">Rs. {{ number_format($product->price) }}</p>
                            @if($product->discount_price)
                                <p class="text-sm font-medium text-gray-400 line-through">Rs. {{ number_format($product->discount_price) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-16 text-center border-2 border-dashed border-gray-200 rounded-2xl">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">No Products Found</h3>
                    <p class="text-gray-500">Try adjusting your filters or search criteria.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $products->withQueryString()->links() }}
            </div>
        </section>

    </main>
</body>
</html>