@extends('layouts.admin')
@section('header', 'Overview')
@section('content')

{{-- ===== HERO BANNER ===== --}}
<div class="relative overflow-hidden bg-gradient-to-br from-indigo-950 via-indigo-800 to-indigo-600 rounded-2xl p-8 mb-6">
    <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/5 rounded-full"></div>
    <div class="absolute -bottom-10 left-1/3 w-40 h-40 bg-white/5 rounded-full"></div>

    <div class="relative z-10 flex items-start justify-between mb-6">
        <div>
            <p class="text-xs font-semibold tracking-widest uppercase text-indigo-300/70 mb-1">Admin Control Panel</p>
            <h2 class="text-2xl font-bold text-white">Welcome to PlugIn Admin</h2>
            <p class="text-sm text-indigo-200/75 mt-1">Here's what's happening across your platform today.</p>
        </div>
        <div class="flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-xs text-white/85 shrink-0">
            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
            All systems operational
        </div>
    </div>

    <div class="relative z-10 grid grid-cols-4 gap-px bg-white/10 rounded-xl overflow-hidden">
        <div class="bg-white/5 px-5 py-4">
            <p class="text-2xl font-bold text-white leading-none mb-1">{{ $stats['total_categories'] }}</p>
            <p class="text-xs text-indigo-200/65 tracking-wide">Categories</p>
        </div>
        <div class="bg-white/5 px-5 py-4">
            <p class="text-2xl font-bold text-white leading-none mb-1">{{ $stats['total_products'] }}</p>
            <p class="text-xs text-indigo-200/65 tracking-wide">Products</p>
        </div>
        <div class="bg-white/5 px-5 py-4">
            <p class="text-2xl font-bold text-white leading-none mb-1">{{ $stats['total_users'] }}</p>
            <p class="text-xs text-indigo-200/65 tracking-wide">Registered Users</p>
        </div>
        <div class="bg-white/5 px-5 py-4">
            <p class="text-2xl font-bold text-white leading-none mb-1">{{ $stats['total_orders'] }}</p>
            <p class="text-xs text-indigo-200/65 tracking-wide">Total Orders</p>
        </div>
    </div>
</div>

{{-- ===== MIDDLE ROW: Quick Nav + Activity ===== --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

    {{-- Quick Navigation --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Quick Navigation</p>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </div>
        @foreach([
            ['icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a0 0 0 014-4z', 'label' => 'Categories', 'color' => 'text-indigo-500 bg-indigo-50'],
            ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'label' => 'Products', 'color' => 'text-purple-500 bg-purple-50'],
            ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'label' => 'Users', 'color' => 'text-emerald-500 bg-emerald-50'],
            ['icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'label' => 'Orders', 'color' => 'text-amber-500 bg-amber-50'],
            ['icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Settings', 'color' => 'text-gray-500 bg-gray-100'],
        ] as $link)
        <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-gray-100 hover:bg-gray-50 cursor-pointer transition mb-2">
            <div class="w-8 h-8 rounded-md flex items-center justify-center {{ $link['color'] }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/></svg>
            </div>
            <span class="text-sm font-medium text-gray-800">{{ $link['label'] }}</span>
            <svg class="w-4 h-4 text-gray-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </div>
        @endforeach
    </div>

    {{-- Recent Activity --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Recent Activity</p>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        @foreach([
            ['dot' => 'bg-indigo-500', 'text' => 'New order placed by a customer', 'time' => '2 minutes ago'],
            ['dot' => 'bg-emerald-500', 'text' => 'New user registered on the platform', 'time' => '14 minutes ago'],
            ['dot' => 'bg-amber-500', 'text' => 'Product stock updated in Electronics', 'time' => '1 hour ago'],
            ['dot' => 'bg-rose-500', 'text' => 'Category "Accessories" marked inactive', 'time' => '3 hours ago'],
            ['dot' => 'bg-indigo-400', 'text' => 'New product added to Clothing', 'time' => 'Yesterday'],
        ] as $activity)
        <div class="flex items-start gap-3 py-2.5 border-b border-gray-50 last:border-0 last:pb-0">
            <span class="w-2 h-2 rounded-full {{ $activity['dot'] }} mt-1.5 shrink-0"></span>
            <div>
                <p class="text-sm text-gray-800 leading-snug">{{ $activity['text'] }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $activity['time'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- ===== BOTTOM ROW: 3 cards ===== --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5">

    {{-- Top Categories Bar Chart --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Top Categories</p>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </div>
        @foreach([
            ['label' => 'Electronics', 'pct' => 85, 'color' => 'bg-indigo-500'],
            ['label' => 'Clothing',    'pct' => 62, 'color' => 'bg-purple-500'],
            ['label' => 'Books',       'pct' => 45, 'color' => 'bg-emerald-500'],
            ['label' => 'Home',        'pct' => 33, 'color' => 'bg-amber-500'],
            ['label' => 'Sports',      'pct' => 21, 'color' => 'bg-rose-500'],
        ] as $bar)
        <div class="flex items-center gap-3 mb-3 last:mb-0">
            <span class="text-xs text-gray-500 w-20 shrink-0">{{ $bar['label'] }}</span>
            <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="{{ $bar['color'] }} h-full rounded-full" style="width:{{ $bar['pct'] }}%"></div>
            </div>
            <span class="text-xs text-gray-400 w-8 text-right shrink-0">{{ $bar['pct'] }}%</span>
        </div>
        @endforeach
    </div>

    {{-- System Health --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">System Health</p>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
        </div>
        @foreach([
            ['key' => 'Database',     'val' => 'Online',     'badge' => 'bg-emerald-100 text-emerald-800'],
            ['key' => 'Storage',      'val' => '72% used',   'badge' => 'bg-amber-100 text-amber-800'],
            ['key' => 'Security',     'val' => 'No alerts',  'badge' => 'bg-emerald-100 text-emerald-800'],
            ['key' => 'Cache',        'val' => 'Healthy',    'badge' => 'bg-emerald-100 text-emerald-800'],
            ['key' => 'Mail Queue',   'val' => '3 pending',  'badge' => 'bg-indigo-100 text-indigo-800'],
        ] as $row)
        <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0">
            <span class="text-xs text-gray-500">{{ $row['key'] }}</span>
            <span class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $row['badge'] }}">{{ $row['val'] }}</span>
        </div>
        @endforeach
    </div>

    {{-- Platform Summary --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Platform Summary</p>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        @foreach([
            ['key' => 'Active Categories', 'val' => $stats['total_categories']],
            ['key' => 'Listed Products',   'val' => $stats['total_products']],
            ['key' => 'Verified Users',    'val' => $stats['total_users']],
            ['key' => 'Orders Today',      'val' => $stats['total_orders']],
        ] as $row)
        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
            <span class="text-xs text-gray-500">{{ $row['key'] }}</span>
            <span class="text-sm font-bold text-gray-800">{{ $row['val'] }}</span>
        </div>
        @endforeach
        <div class="flex items-center justify-between pt-2.5">
            <span class="text-xs text-gray-500">Platform Version</span>
            <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-800">v1.0.0</span>
        </div>
    </div>
</div>

@endsection