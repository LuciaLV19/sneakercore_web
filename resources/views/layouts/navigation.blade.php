<nav x-data="{ open: false }" class="bg-bg-white border-b border-gray-100 font-['Instrument_Sans']">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            {{-- Shop Name --}}
            <div class="font-black text-2xl tracking-tighter text-dark shrink-0">
                <a href="{{ route('home') }}">
                    SNEAKER<span class="text-brand-primary-soft">CORE</span>
                </a>
            </div>

            {{-- Search Bar --}}
            <div class="hidden md:flex items-center flex-1 justify-center px-10 group">
                <div class="relative w-full max-w-md">
                    <form action="{{ route('shop.index') }}" method="GET">
                        <input type="text" name="search" placeholder="{{ __('Search sneakers...') }}" 
                               class="w-full bg-bg-light border-2 border-transparent rounded-full py-2 pl-10 text-sm focus:ring-0 focus:border-brand-primary focus:bg-bg-white transition-all">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-brand-primary"></i>
                    </form>
                </div>
            </div>

            {{-- Right Side --}}
            <div class="flex items-center gap-6">

                {{-- Theme Toggle --}}
                <button id="theme-toggle" class="text-gray-400 hover:text-brand-primary-soft transition-colors focus:outline-none">
                    <i id="theme-toggle-dark-icon" class="fa-solid fa-moon text-lg hidden"></i>
                    <i id="theme-toggle-light-icon" class="fa-solid fa-lightbulb text-lg hidden"></i>
                </button>

                {{-- Language Switcher --}}
                <x-dropdown align="right" width="32">
                    <x-slot name="trigger">
                        <button class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-brand-primary-soft transition-colors">
                            {{ strtoupper(app()->getLocale()) }} <i class="fa-solid fa-chevron-down ml-1 text-[10px]"></i>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('locale.switch', 'en') }}">{{ __('English') }}</x-dropdown-link>
                        <x-dropdown-link href="{{ route('locale.switch', 'es') }}">{{ __('Spanish') }}</x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="relative text-dark hover:text-brand-primary-soft transition-colors">
                    <i class="fas fa-shopping-cart text-[22px]"></i>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-brand-primary text-white text-[10px] font-black px-1.5 rounded-full border-2 border-white">
                            {{ array_sum(array_column(session('cart'), 'quantity')) }}
                        </span>
                    @endif
                </a>

                {{-- Wishlist --}}
                <a href="{{ route('wishlist.index') }}" class="relative text-dark hover:text-brand-primary-soft transition-colors">
                    <i class="fa-solid fa-heart text-[21px]"></i>
                    @if(session('wishlist') && count(session('wishlist')) > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-black px-1.5 rounded-full border-2 border-white">
                            {{ count(session('wishlist')) }}
                        </span>
                    @endif
                </a>

                {{-- User Account --}}
                <div class="flex gap-4 items-center border-l pl-6 border-gray-100">
                    @auth
                        {{-- Dropdown Content --}}
                        <x-dropdown align="right" width="56">
                            {{-- Dropdown Trigger --}}
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 font-black uppercase text-dark tracking-tighter hover:text-brand-primary-soft transition-colors">
                                    <i class="fa-solid fa-circle-user text-2xl"></i>
                                    <span class="hidden lg:inline text-sm">{{ Auth::user()->name }}</span>

                                    <i class="fa-solid fa-chevron-down text-[10px] ml-1 text-gray-400 group-hover:text-brand-primary-soft transition-transform duration-300"></i>
                                </button>
                            </x-slot>
                            {{-- Dropdown Content --}}
                            <x-slot name="content">
                                <div class="px-4 py-2 border-b border-gray-50">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Account') }}</p>
                                    <p class="text-sm font-bold truncate">{{ Auth::user()->email }}</p>
                                </div>
                                {{-- Admin Dashboard Link --}}
                                @if(Auth::user()->role == 1)
                                    <x-dropdown-link :href="route('admin.dashboard')" class="text-brand-primary font-black">
                                        <i class="fa-solid fa-gauge-high mr-2"></i> {{ __('Admin Dashboard') }}
                                    </x-dropdown-link>
                                @endif

                                {{-- Profile Link --}}
                                <x-dropdown-link :href="route('profile.index')">
                                    <i class="fa-solid fa-user mr-2"></i> {{ __('Account') }}
                                </x-dropdown-link>

                                {{-- Settings Profile Link --}}
                                <x-dropdown-link :href="route('profile.edit')">
                                    <i class="fa-solid fa-user-gear mr-2"></i> {{ __('Settings') }}
                                </x-dropdown-link>

                                {{-- My Orders Link --}}
                                <x-dropdown-link :href="route('orders.index')">
                                    <i class="fa-solid fa-box mr-2"></i> {{ __('My Orders') }}
                                </x-dropdown-link>

                                {{-- Logout --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500 font-bold">
                                        <i class="fa-solid fa-power-off mr-2"></i> {{ __('Logout') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    {{-- If not authenticated, show login and register links --}}
                    @else
                        <a href="{{ route('login') }}" class="font-bold text-sm uppercase tracking-tighter">{{ __('Login') }}</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-black text-white rounded-full font-black text-xs hover:bg-brand-primary transition-all uppercase tracking-tighter">
                            {{ __('Register') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- Navigation Links --}}
    <div class="w-full border-t border-gray-100">
        <div class="max-w-7xl mx-auto flex justify-center items-center gap-10 relative">

            {{-- Genders --}}
            @foreach($genders as $gender)
                <div class="group py-3">
                    <a href="{{ route('shop.index', ['gender' => $gender->name]) }}" class="font-black text-dark tracking-tighter uppercase text-[18px] group-hover:text-brand-primary-soft transition-colors">{{ __($gender->name) }}</a>

                    {{-- Dropdown Content --}}
                    <div class="absolute left-0 top-full w-full bg-bg-white border border-t-0 border-gray-100 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 p-8 grid grid-cols-4 gap-8">
                        
                        {{-- Usages --}}
                        <div>
                            <h4 class="font-black italic text-[18px]} mb-4 text-gray-400 uppercase">{{ __('Sneakers') }}</h4>
                            <ul class="space-y-2">
                                @foreach($usages as $usage)
                                    <li><a href="{{ route('shop.index', ['gender' => $gender->name, 'usage' => $usage->name]) }}" class="text-[15px] xl:text-[16px] font-bold hover:text-brand-primary-soft uppercase">{{ $usage->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Brands --}}
                        <div>
                            <h4 class="font-black italic text-[18px] mb-4 text-gray-400 uppercase">{{ __('Brands') }}</h4>
                            <div class="grid grid-cols-1 xl:grid-cols-2 gap-x-4 gap-y-2">
                                @foreach($brands->chunk(6) as $chunk)
                                    <ul class="space-y-2">
                                        @foreach($chunk as $brand)
                                            <li>
                                                <a href="{{ route('shop.index', ['gender' => $gender->name, 'brand' => $brand->name]) }}" 
                                                class="text-[15px] xl:text-[16px] font-bold hover:text-brand-primary-soft uppercase transition-colors block whitespace-nowrap">
                                                    {{ __($brand->name) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                        </div>

                        {{-- Featured Product --}}
                        <div class="col-span-2 border-l border-gray-100 p-4 rounded flex justify-between">
                            <div class="max-w-[220px]">
                                @if($gender->name == 'Men')
                                    <span class="text-brand-primary-soft font-black italic xl:text-2xl text-xl leading-none">NIKE AIR MAX PLUS</span>
                                    <p class="text-base mt-4 mb-7 font-bold text-gray-500 uppercase">Domina las calles.</p>
                                    <a href="{{ route('shop.show', 14) }}" class="text-base font-black uppercase p-3 m-2 bg-brand-primary text-white">Comprar</a>
                                @elseif($gender->name == 'Women')
                                    <span class="text-brand-primary-soft font-black italic xl:text-2xl text-xl leading-none">NIKE STRUCTURE 26</span>
                                    <p class="text-base mt-4 mb-7 font-bold text-gray-500 uppercase">{{ __('Runs towards the limit')}}.</p>
                                    <a href="{{ route('shop.show', 92) }}" class="text-base font-black uppercase p-3 m-2 bg-brand-primary text-white">Comprar</a>
                                @else
                                    <span class="text-brand-primary-soft font-black italic xl:text-2xl text-xl leading-none">LACOSTE AMPTHILL 118</span>
                                    <p class="text-base mt-4 mb-7 font-bold text-gray-500 uppercase">{{ __('Ready for the game.')}}</p>
                                    <a href="{{ route('shop.show', 89) }}" class="text-base font-black uppercase p-3 m-2 bg-brand-primary text-white">Comprar</a>
                                @endif
                            </div>

                            {{-- Image --}}
                            <img src="
                                @if($gender->name == 'Men')
                                    {{ asset('images/products/nike/nike_air_max_plus_14.webp') }}
                                @elseif($gender->name == 'Women')
                                    {{ asset('images/products/nike/nike_structure_26.webp') }}
                                @else
                                    {{ asset('images/products/lacoste/lacoste_ampthill_118.webp') }}
                                @endif
                            " class="w-64 h-44 object-contain">
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- New Arrivals Link --}}
            <a href="{{ route('new-arrivals') }}" class="py-3 font-black tracking-tighter uppercase text-[18px] text-brand-primary-soft">{{ __('New Arrivals')}}</a>

            {{-- Brands Mega Menu --}}
            <div class="group py-3">
                <button class="font-black text-dark tracking-tighter uppercase text-[18px] group-hover:text-brand-primary-soft transition-colors cursor-default">
                    {{ __('Brands') }}
                </button>

                <div class="absolute left-0 top-full w-full bg-bg-white border border-t-0 border-gray-100 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 p-8">
                    <div class="max-w-6xl mx-auto">
                        <h4 class="font-black italic text-base mb-6 text-gray-400 uppercase tracking-widest border-b pb-2">
                            {{ __('Our Top Brands') }}
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                            @foreach($brands as $brand)
                                <a href="{{ route('shop.index', ['brand' => $brand->name]) }}" 
                                    class="flex items-center justify-center p-6 bg-gray-50 rounded-sm hover:bg-light hover:shadow-md transition-all group/brand border border-transparent hover:border-gray-100">
                                    <img src="{{ asset('images/icons/' . Str::slug($brand->name) . '.svg') }}" 
                                        alt="{{ $brand->name }}" 
                                        class="w-full h-full p-2 object-contain filter group-hover:brightness-110 transition-all">
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-8 text-center">
                            <a href="{{ route('shop.index') }}" class="text-base font-bold underline uppercase hover:text-brand-primary-soft">
                                {{ __('View the full catalog') }}
                            </a>
                        </div>
                    </div>
                </div>                 {{-- Sale Link --}}
            </div>                    <a href="#" class="py-3 font-black tracking-tighter uppercase text-[18px] bg-black text-white px-3 my-2 hover:bg-brand-secondary-soft transition-colors">{{ __('Sale') }}</a>
        </div>
    </div>
</nav>