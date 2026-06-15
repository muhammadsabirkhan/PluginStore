@extends('layouts.admin')

@section('header', 'Products Management')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg font-medium">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">All Products</h3>
        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            + Add New Product
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm border-b border-gray-200">
                    <th class="p-4 font-semibold">Image</th>
                    <th class="p-4 font-semibold">Name & SKU</th>
                    <th class="p-4 font-semibold">Category</th>
                    <th class="p-4 font-semibold">Price</th>
                    <th class="p-4 font-semibold">Stock</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="p-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded object-cover border">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Img</div>
                        @endif
                    </td>
                    <td class="p-4">
                        <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                        <p class="text-xs text-gray-500">SKU: {{ $product->sku }}</p>
                    </td>
                    <td class="p-4 text-sm text-gray-600">{{ $product->category->name }}</td>
                    <td class="p-4 text-sm font-semibold text-gray-900">Rs. {{ number_format($product->price) }}</td>
                    <td class="p-4 text-sm">
                        @if($product->stock_quantity > 10)
                            <span class="text-green-600 font-medium">{{ $product->stock_quantity }} in stock</span>
                        @else
                            <span class="text-red-600 font-medium">{{ $product->stock_quantity }} Low Stock!</span>
                        @endif
                    </td>
                    
                    <td class="p-4 flex gap-4 text-sm font-medium justify-end items-center mt-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline transition">Edit</a>
                        
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline-block m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 hover:underline transition">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-gray-500">No products found. Add your first electronic item!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection