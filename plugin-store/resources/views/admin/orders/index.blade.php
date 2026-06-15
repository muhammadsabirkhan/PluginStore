@extends('layouts.admin')

@section('header', 'Order Management')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm border-b border-gray-200">
                    <th class="p-4 font-semibold">Order ID</th>
                    <th class="p-4 font-semibold">Customer Details</th>
                    <th class="p-4 font-semibold">Total Amount</th>
                    <th class="p-4 font-semibold">Payment</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="p-4 font-medium text-gray-900">#{{ $order->id }}</td>
                    <td class="p-4">
                        <p class="text-sm font-semibold text-gray-900">{{ $order->full_name }}</p>
                        <p class="text-xs text-gray-500">{{ $order->phone }} | {{ $order->city }}</p>
                    </td>
                    <td class="p-4 font-bold text-gray-900">Rs. {{ number_format($order->total_amount) }}</td>
                    <td class="p-4">
                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-2 py-1 rounded">
                            {{ $order->payment_method }}
                        </span>
                    </td>
                    <td class="p-4">
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="order_status" onchange="this.form.submit()" class="text-xs font-bold rounded-md px-3 py-1.5 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-200 
                                {{ $order->order_status == 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                {{ $order->order_status == 'processing' ? 'bg-blue-50 text-blue-700' : '' }}
                                {{ $order->order_status == 'shipped' ? 'bg-purple-50 text-purple-700' : '' }}
                                {{ $order->order_status == 'delivered' ? 'bg-green-50 text-green-700' : '' }}
                            ">
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                        </form>
                    </td>
                    <td class="p-4 text-sm text-gray-500">{{ $order->created_at->format('d M, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-gray-500">No orders received yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection