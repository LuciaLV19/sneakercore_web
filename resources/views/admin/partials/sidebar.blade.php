<aside class="w-[260px] min-h-screen bg-brand-secondary text-bg-white flex flex-col font-font-main">
    
    {{-- Sidebar Header --}}
    <div class="text-light p-6 text-[1.3rem] font-bold tracking-wider text-center border-b border-white/[0.247]">
        SNEAKERS ADMIN
    </div>

    {{-- Sidebar Navigation --}}
    <nav class="flex-1 py-4">
        @php
            $baseClass = "flex items-center gap-3 px-6 py-4 text-light no-underline font-bold transition-all duration-200 ease-in-out hover:bg-[#9090904c]";
            $activeClass = "bg-brand-primary border-l-4 border-brand-primary-soft";
        @endphp

        <a href="{{ route('admin.dashboard') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('admin.dashboard') ? $activeClass : '' }}">
            <i class="fas fa-chart-pie w-5"></i> {{ __('Dashboard') }}
        </a>

        <a href="{{ route('admin.products.index') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('admin.products.*') ? $activeClass : '' }}">
            <i class="fas fa-shoe-prints w-5"></i> {{ __('Products') }}
        </a>

        <a href="{{ route('admin.users.index') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('admin.users.*') ? $activeClass : '' }}">
            <i class="fas fa-users w-5"></i> {{ __('Users') }}
        </a>

        <a href="{{ route('admin.orders.index') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('admin.orders.*') ? $activeClass : '' }}">
            <i class="fas fa-box w-5"></i> {{ __('Orders') }}
        </a>

        <a href="{{ route('admin.shipping.index') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('admin.shipping.*') ? $activeClass : '' }}">
            <i class="fas fa-truck w-5"></i> {{ __('Shipping Config') }}
        </a>

        <a href="{{ route('admin.discounts.index') }}" 
           class="{{ $baseClass }} {{ request()->routeIs('admin.discounts.*') ? $activeClass : '' }}">
            <i class="fas fa-tag w-5"></i> {{ __('Discount codes') }}
        </a>
    </nav>

    {{-- Sidebar Footer --}}
    <div class="p-6 border-t border-white/[0.247]">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-500 font-bold p-3 w-full text-left hover:bg-black/5 transition-colors">
                🔴 {{ __('Log Out') }}
            </button>
        </form>
    </div>
</aside>