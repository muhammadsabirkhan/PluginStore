<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlugIn - Smart Electronics & Gadgets</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; }
        .glass-nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.3); }
        .product-card { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        /* Custom Scrollbar for dropdown */
        .search-results::-webkit-scrollbar { width: 6px; }
        .search-results::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="glass-nav fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center relative">
            <a href="{{ route('home') }}" class="flex items-center gap-2 nav-logo">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/50">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">PlugIn<span class="text-blue-600">.</span></h1>
            </a>

            <div id="nav-links" class="hidden md:flex gap-8 font-medium text-sm text-gray-600 nav-links transition-opacity duration-300">
                <a href="{{ route('shop.index') }}" class="hover:text-blue-600 transition">Shop All</a>
                <a href="{{ route('shop.new_arrivals') }}" class="hover:text-blue-600 transition">New Arrivals</a>
                <a href="{{ route('shop.deals') }}" class="hover:text-blue-600 transition">Deals</a>
            </div>

            <div id="sticky-search" class="absolute left-1/2 transform -translate-x-1/2 w-full max-w-md hidden md:block opacity-0 pointer-events-none transition-all duration-300">
                <div class="relative">
                    <input type="text" class="live-search-input w-full bg-gray-100 border border-gray-200 rounded-full px-5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 font-medium placeholder-gray-500" placeholder="Search gadgets..." autocomplete="off">
                    <div class="search-results absolute w-full bg-white mt-2 rounded-xl shadow-xl border border-gray-100 hidden z-50 overflow-hidden text-left top-full left-0 max-h-96 overflow-y-auto"></div>
                </div>
            </div>

            <div class="flex items-center gap-4 nav-actions">
                <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-blue-600 transition relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ count((array) session('cart')) }}</span>
                </a>

                @auth
                    <a href="{{ route('user.dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-blue-600 transition">My Account</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0">
                        @csrf
                        <button type="submit" class="text-sm font-semibold bg-red-50 text-red-600 border border-red-100 px-5 py-2 rounded-full hover:bg-red-100 transition shadow-sm">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold bg-blue-600 text-white px-5 py-2 rounded-full hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition">Log in</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="pt-32 pb-20 px-4 bg-gradient-to-b from-white to-gray-50 overflow-hidden relative">
        <div class="max-w-7xl mx-auto text-center relative z-10 hero-content">
            <div class="inline-block px-4 py-1.5 rounded-full bg-white text-blue-600 font-semibold text-sm mb-6 border border-gray-100 shadow-sm hero-badge">
                ✨ The Next Generation of Tech
            </div>
            <h2 class="text-5xl md:text-7xl font-extrabold text-gray-900 mb-6 tracking-tight hero-title">
                Upgrade Your Life with <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Smart Gadgets</span>
            </h2>
            <p class="text-lg md:text-xl text-gray-500 mb-10 max-w-2xl mx-auto hero-desc">
                Discover the latest smartphones, premium laptops, and intelligent home appliances. Unbeatable prices, guaranteed quality.
            </p>

            <div class="max-w-3xl mx-auto hero-search relative z-20">
                <form onsubmit="event.preventDefault();" class="flex flex-col sm:flex-row items-center bg-white rounded-full p-2 shadow-xl shadow-gray-200/50 border border-gray-100 relative">
                    
                    <select name="category" class="hidden sm:block bg-transparent text-gray-600 font-medium px-6 py-3 border-r border-gray-200 focus:outline-none cursor-pointer rounded-l-full">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>

                    <div class="flex-1 flex items-center px-6 w-full mt-2 sm:mt-0">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" class="live-search-input w-full bg-transparent focus:outline-none text-gray-900 placeholder-gray-400 font-medium" placeholder="Search for smartphones, laptops, audio..." autocomplete="off">
                    </div>

                    <button type="submit" class="w-full sm:w-auto mt-2 sm:mt-0 bg-blue-600 text-white font-bold py-3.5 px-8 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                        Search
                    </button>
                </form>
                
                <div class="search-results absolute w-full bg-white mt-2 rounded-2xl shadow-2xl border border-gray-100 hidden z-50 overflow-hidden text-left top-full left-0 max-h-96 overflow-y-auto"></div>
            </div>

        </div>
    </header>

    <section class="py-16 px-4 max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-10 section-header">
            <div>
                <h3 class="text-3xl font-bold text-gray-900">Trending Now</h3>
                <p class="text-gray-500 mt-2">Our most popular electronics right now.</p>
            </div>
            <a href="{{ route('shop.index') }}" class="text-blue-600 font-semibold hover:underline">View All &rarr;</a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg font-medium text-center shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($products as $product)
            <div class="product-card bg-white rounded-2xl p-4 border border-gray-100 group flex flex-col relative">
                <a href="{{ route('product.show', $product->slug) }}" class="relative bg-gray-50 rounded-xl aspect-square mb-4 overflow-hidden flex items-center justify-center cursor-pointer">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain w-full h-full mix-blend-multiply group-hover:scale-110 transition duration-500">
                    @else
                        <span class="text-gray-400">No Image</span>
                    @endif
                    
                    <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="z-10">
                            @csrf
                            <button type="submit" class="bg-white text-gray-900 font-bold py-2 px-6 rounded-full transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 shadow-lg hover:bg-blue-600 hover:text-white">
                                Quick Add
                            </button>
                        </form>
                    </div>
                </a>
                
                <div class="space-y-1 mt-auto">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">{{ $product->category->name }}</p>
                    <a href="{{ route('product.show', $product->slug) }}" class="hover:text-blue-600 transition">
                        <h4 class="text-lg font-bold text-gray-900 leading-tight line-clamp-1">{{ $product->name }}</h4>
                    </a>
                    <div class="flex justify-between items-center pt-2">
                        <p class="text-xl font-extrabold text-gray-900">Rs. {{ number_format($product->price) }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                No products found. Please add products from the admin panel.
            </div>
            @endforelse
        </div>
    </section>

      <script>
        document.addEventListener("DOMContentLoaded", () => {
            // GSAP Animations
            gsap.from(".hero-badge", { y: 30, opacity: 0, duration: 0.8, delay: 0.1, ease: "back.out(1.7)" });
            gsap.from(".hero-title", { y: 40, opacity: 0, duration: 1, delay: 0.3, ease: "power4.out" });
            gsap.from(".hero-desc", { y: 20, opacity: 0, duration: 0.8, delay: 0.5, ease: "power3.out" });
            gsap.from(".hero-search", { y: 30, opacity: 0, duration: 0.8, delay: 0.7, ease: "power3.out" });

            // Sticky Search Bar Scroll Logic
            const navLinks = document.getElementById('nav-links');
            const stickySearch = document.getElementById('sticky-search');

            window.addEventListener('scroll', () => {
                if(window.scrollY > 400) { 
                    navLinks.classList.add('opacity-0', 'pointer-events-none'); 
                    stickySearch.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
                    stickySearch.classList.add('opacity-100', 'pointer-events-auto'); 
                } else {
                    navLinks.classList.remove('opacity-0', 'pointer-events-none');
                    stickySearch.classList.add('opacity-0', 'pointer-events-none');
                    stickySearch.classList.remove('opacity-100', 'pointer-events-auto');
                }
            });

            // -----------------------------------------------------
            // LIVE AJAX SEARCH & TWO-WAY SYNC LOGIC
            // -----------------------------------------------------
            const searchInputs = document.querySelectorAll('.live-search-input');
            const resultDivs = document.querySelectorAll('.search-results');

            // 1. Sync text between both search bars
            searchInputs.forEach(input => {
                input.addEventListener('input', function() {
                    let val = this.value;
                    searchInputs.forEach(otherInput => {
                        if(otherInput !== this) otherInput.value = val;
                    });
                });
            });

            // 2. Fetch Results and show in both dropdowns
            searchInputs.forEach(input => {
                input.addEventListener('keyup', function(e) {
                    let query = this.value;

                    // Agar user Enter dabaye toh Shop page par le jao
                    if(e.key === 'Enter') {
                        window.location.href = `/shop?search=${query}`;
                        return;
                    }

                    if(query.length > 1) { 
                        fetch(`/ajax-search?q=${query}`)
                        .then(res => res.json())
                        .then(data => {
                            let html = '';
                            if(data.length > 0) {
                                data.forEach(item => {
                                    let imgStr = item.image ? `/storage/${item.image}` : '';
                                    let numFormat = new Intl.NumberFormat('en-PK').format(item.price);
                                    html += `
                                        <a href="/product/${item.slug}" class="flex items-center gap-4 p-4 hover:bg-gray-50 border-b border-gray-50 transition">
                                            <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center overflow-hidden">
                                                ${item.image ? `<img src="${imgStr}" class="w-full h-full object-contain mix-blend-multiply">` : `<span class="text-[10px] text-gray-400">No Img</span>`}
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-bold text-gray-900 line-clamp-1">${item.name}</h4>
                                                <p class="text-xs font-bold text-blue-600 mt-1">Rs. ${numFormat}</p>
                                            </div>
                                        </a>
                                    `;
                                });
                            } else {
                                html = '<div class="p-6 text-sm text-gray-500 text-center font-medium">No products found</div>';
                            }
                            
                            // Ek sath dono dropdowns update karo
                            resultDivs.forEach(div => {
                                div.innerHTML = html;
                                div.classList.remove('hidden');
                            });
                        }).catch(err => console.error("AJAX Error:", err));
                    } else {
                        // Agar query empty hai toh dono dropdowns hide karo
                        resultDivs.forEach(div => {
                            div.innerHTML = '';
                            div.classList.add('hidden');
                        });
                    }
                });
            });

            // Close dropdown when clicking anywhere else
            document.addEventListener('click', (e) => {
                if(!e.target.closest('.search-results') && !e.target.closest('.live-search-input')) {
                    resultDivs.forEach(el => el.classList.add('hidden'));
                }
            });
        });
    </script>
</body>
</html>