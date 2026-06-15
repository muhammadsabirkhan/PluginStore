<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - PlugIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; overflow-x: hidden; }</style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="bg-white border-b border-gray-100 p-4 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">PlugIn<span class="text-blue-600">.</span></h1>
            </a>
            
            <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-blue-600 transition relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                    {{ count((array) session('cart')) }}
                </span>
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-12">
        
        @if(session('success'))
            <div class="mb-8 p-4 bg-green-100 text-green-700 rounded-lg font-medium shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }} <a href="{{ route('cart.index') }}" class="underline font-bold ml-2">View Cart</a>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
            
            <div class="w-full md:w-1/2 p-8 md:p-16 flex items-center justify-center bg-gray-50 border-r border-gray-100">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full max-w-md object-contain hover:scale-105 transition-transform duration-500 mix-blend-multiply">
                @else
                    <div class="w-64 h-64 bg-gray-200 rounded-2xl flex items-center justify-center text-gray-500 font-medium">No Image Available</div>
                @endif
            </div>

            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                <p class="text-sm font-bold text-blue-600 uppercase tracking-widest mb-2">{{ $product->category->name }}</p>
                <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-4">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 mb-6">
                    <span class="text-3xl font-extrabold text-gray-900">Rs. {{ number_format($product->price) }}</span>
                    @if($product->stock_quantity > 0)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">In Stock ({{ $product->stock_quantity }})</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Out of Stock</span>
                    @endif
                </div>

                <div class="text-sm text-gray-500 mb-8 border-t border-b border-gray-100 py-4">
                    <p><span class="font-semibold text-gray-700">SKU:</span> {{ $product->sku }}</p>
                </div>

                <p class="text-gray-600 mb-8 leading-relaxed">{{ $product->description }}</p>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex items-center gap-4">
                    @csrf
                    <div class="flex items-center border border-gray-200 rounded-full bg-gray-50 px-4 py-2">
                        <label class="text-sm font-semibold text-gray-600 mr-3">Qty:</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-12 bg-transparent text-center font-bold text-gray-900 focus:outline-none">
                    </div>
                    
                    <button type="submit" @if($product->stock_quantity < 1) disabled @endif class="flex-1 bg-blue-600 text-white font-bold py-3.5 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-500/30 disabled:bg-gray-400 disabled:shadow-none disabled:cursor-not-allowed">
                        {{ $product->stock_quantity > 0 ? 'Add to Cart' : 'Out of Stock' }}
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-20 border-t border-gray-100 pt-16">
            <h3 class="text-2xl font-bold text-gray-900 mb-8">Customer Reviews</h3>
            
            <div class="flex flex-col md:flex-row gap-12">
                <div class="w-full md:w-1/3">
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Write a Review</h4>
                        
                        @auth
                            @if(session('error'))
                                <div class="mb-4 text-sm text-red-600 bg-red-50 p-2 rounded">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('review.store', $product->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                    <select name="rating" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                                        <option value="5">⭐⭐⭐⭐⭐ (5/5) - Excellent</option>
                                        <option value="4">⭐⭐⭐⭐ (4/5) - Very Good</option>
                                        <option value="3">⭐⭐⭐ (3/5) - Average</option>
                                        <option value="2">⭐⭐ (2/5) - Poor</option>
                                        <option value="1">⭐ (1/5) - Terrible</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Review</label>
                                    <textarea name="comment" rows="4" required placeholder="Share your experience..." class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-gray-900 text-white font-bold py-2.5 rounded-lg hover:bg-gray-800 transition">Submit Review</button>
                            </form>
                        @else
                            <p class="text-sm text-gray-600 mb-4">You must be logged in to post a review.</p>
                            <a href="{{ route('login') }}" class="block text-center bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">Log in to Review</a>
                        @endauth
                    </div>
                </div>

                <div class="w-full md:w-2/3 space-y-6">
                    @forelse($product->reviews as $review)
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold uppercase">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="font-bold text-gray-900">{{ $review->user->name }}</h5>
                                    <p class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="text-yellow-400 text-sm">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= $review->rating) ★ @else ☆ @endif
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $review->comment }}</p>
                    </div>
                    @empty
                    <div class="text-center py-12 border-2 border-dashed border-gray-100 rounded-2xl">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">No Reviews Yet</h3>
                        <p class="text-gray-500">Be the first to review this product!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @if($relatedProducts->count() > 0)
        <div class="mt-20">
            <h3 class="text-2xl font-bold text-gray-900 mb-8 border-b border-gray-100 pb-4">You May Also Like</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <a href="{{ route('product.show', $related->slug) }}" class="group block bg-white rounded-2xl p-4 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300">
                    <div class="bg-gray-50 rounded-xl aspect-square mb-4 flex items-center justify-center p-4">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition duration-500">
                        @endif
                    </div>
                    <p class="text-xs font-semibold text-blue-600 uppercase">{{ $related->category->name }}</p>
                    <h4 class="text-base font-bold text-gray-900 leading-tight mt-1 line-clamp-1">{{ $related->name }}</h4>
                    <p class="text-lg font-extrabold text-gray-900 mt-2">Rs. {{ number_format($related->price) }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </main>

</body>
</html>