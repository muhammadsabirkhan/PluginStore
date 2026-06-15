@extends('layouts.admin')

@section('header', 'Add New Category')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-800">New Category Details</h3>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-blue-600 transition">&larr; Back to Categories</a>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Smart Watches" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-8">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <span class="ml-3 text-sm font-medium text-gray-700">Category is Active</span>
            </label>
        </div>

        <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition">
            Save Category
        </button>
    </form>
</div>
@endsection