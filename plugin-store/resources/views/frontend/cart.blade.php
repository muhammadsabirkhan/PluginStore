<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - PlugIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-600 hover:text-blue-600">&larr; Continue Shopping</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Your Cart</h2>

        @if(session('cart') && count(session('cart')) > 0)
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-2/3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-sm text-gray-500">
                            <th class="pb-4 font-semibold">Product</th>
                            <th class="pb-4 font-semibold">Price</th>
                            <th class="pb-4 font-semibold text-center">Qty</th>
                            <th class="pb-4 font-semibold text-right">Subtotal</th>
                            <th class="pb-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('cart') as $id => $details)
                        <tr class="border-b border-gray-50 cart-row" data-id="{{ $id }}">
                            <td class="py-4 flex items-center gap-4">
                                @if($details['image'])
                                    <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-16 h-16 rounded object-cover border">
                                @else
                                    <div class="w-16 h-16 bg-gray-100 rounded"></div>
                                @endif
                                <span class="font-semibold text-gray-900">{{ $details['name'] }}</span>
                            </td>
                            <td class="py-4 text-gray-600">Rs. {{ number_format($details['price']) }}</td>
                            <td class="py-4 text-center">
                                <input type="number" value="{{ $details['quantity'] }}" class="quantity update-cart w-16 text-center border rounded py-1 focus:outline-none focus:ring-1 focus:ring-blue-500" min="1">
                            </td>
                            <td class="py-4 text-right font-semibold text-gray-900">Rs. {{ number_format($details['price'] * $details['quantity']) }}</td>
                            <td class="py-4 text-right">
                                <button class="remove-from-cart text-red-500 hover:text-red-700 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

               <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Order Summary</h3>

                    @if(session('error'))
                        <div class="mb-4 text-sm text-red-600 bg-red-50 p-2 rounded">{{ session('error') }}</div>
                    @endif
                    @if(session('success'))
                        <div class="mb-4 text-sm text-green-600 bg-green-50 p-2 rounded">{{ session('success') }}</div>
                    @endif

                    <div class="flex justify-between mb-4 text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-semibold text-gray-900">Rs. {{ number_format($subtotal) }}</span>
                    </div>

                    @if(session()->has('coupon'))
                    <div class="flex justify-between mb-4 text-green-600">
                        <span>
                            Discount ({{ session('coupon')['code'] }})
                            <form action="{{ route('cart.remove_coupon') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-500 text-xs ml-2 hover:underline">[Remove]</button>
                            </form>
                        </span>
                        <span class="font-bold">- Rs. {{ number_format($discount) }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between mb-6 text-gray-600">
                        <span>Delivery Info</span>
                        <span class="text-sm text-green-600">Calculated at Checkout</span>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-4 mb-6 flex justify-between items-center">
                        <span class="text-xl font-bold text-gray-900">Total</span>
                        <span class="text-2xl font-extrabold text-blue-600">Rs. {{ number_format($total) }}</span>
                    </div>

                    @if(!session()->has('coupon'))
                    <form action="{{ route('cart.coupon') }}" method="POST" class="mt-4 flex gap-2">
                        @csrf
                        <input type="text" name="code" placeholder="ENTER PROMO CODE" required class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 uppercase font-medium">
                        
                        <button type="submit" class="bg-gray-900 text-white px-6 py-3 rounded-xl font-medium hover:bg-gray-800 transition shadow-sm">
                            Apply
                        </button>
                    </form>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('checkout.index') }}" class="w-full block text-center bg-blue-600 text-white font-bold py-3.5 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                            Proceed to Checkout &rarr;
                        </a>
                    </div>
            </div>
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-2xl border border-gray-100">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
            <p class="text-gray-500 mb-6">Looks like you haven't added anything yet.</p>
            <a href="{{ route('home') }}" class="bg-blue-600 text-white font-semibold py-2.5 px-6 rounded-full hover:bg-blue-700 transition">Start Shopping</a>
        </div>
        @endif
    </main>

    <script>
        $(".update-cart").change(function (e) {
            e.preventDefault();
            var ele = $(this);
            $.ajax({
                url: '{{ route('cart.update') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id"), 
                    quantity: ele.val()
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            if(confirm("Are you sure want to remove this product?")) {
                $.ajax({
                    url: '{{ route('cart.remove') }}',
                    method: "delete",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
</body>
</html>