@extends('layouts.admin')
@section('header', 'Coupons & Deals Management')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Create New Coupon</h3>
            
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Coupon Code</label>
                    <input type="text" name="code" placeholder="e.g. PLUGIN20" required class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 uppercase">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Discount Type</label>
                    <select name="type" required class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500">
                        <option value="percent">Percentage (%)</option>
                        <option value="fixed">Fixed Amount (Rs.)</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Discount Value</label>
                    <input type="number" name="value" placeholder="e.g. 20" required class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2.5 rounded-lg hover:bg-blue-700">Generate Coupon</button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 text-sm">
                    <tr>
                        <th class="p-4">Code</th>
                        <th class="p-4">Type</th>
                        <th class="p-4">Value</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                    <tr class="border-b">
                        <td class="p-4 font-bold text-blue-600">{{ $coupon->code }}</td>
                        <td class="p-4 text-sm capitalize">{{ $coupon->type }}</td>
                        <td class="p-4 text-sm font-medium">
                            {{ $coupon->type == 'percent' ? $coupon->value.'%' : 'Rs. '.$coupon->value }}
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Delete this coupon?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline text-sm font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection