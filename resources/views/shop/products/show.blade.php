<x-app-layout>
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="flex mb-6 overflow-x-auto whitespace-nowrap no-scrollbar" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    {{-- Link Home --}}
                    <li class="inline-flex items-center">
                        <a href="/" class="text-[10px] md:text-xs font-bold text-gray-400 hover:text-brand-primary uppercase tracking-widest transition-colors">
                            {{ __('Home') }}
                        </a>
                    </li>

                    {{-- Links Categories --}}
                    @foreach($product->categories as $category)
                        <li class="flex items-center">
                            <span class="text-gray-300 text-xs px-1">/</span>
                            <a href="{{ route('shop.index', [$category->type => $category->name]) }}" 
                                class="text-[10px] md:text-xs font-bold text-gray-400 hover:text-brand-primary uppercase tracking-widest transition-colors">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach

                    {{-- Current Product Name --}}
                    <li class="flex items-center" aria-current="page">
                        <span class="text-gray-300 text-xs px-1">/</span>
                        <span class="text-[10px] md:text-xs font-black text-brand-primary-soft uppercase tracking-widest truncate max-w-[120px] md:max-w-none">
                            {{ $product->name }}
                        </span>
                    </li>
                </ol>
            </nav>

            {{-- Main Content --}}
            <div class="bg-bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                {{-- Principal Grid - Image + Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">

                    {{-- Product Image Column --}}
                    <div>
                        <div class="rounded-lg shadow-lg overflow-hidden">
                            <img src="{{ asset('images/products/' . $product->img) }}?v={{ optional($product->updated_at)->timestamp }}" 
                                 class="w-full transition-all duration-300 {{ $product->stock <= 0 ? 'brightness-[0.4] grayscale-[0.5]' : '' }}" 
                                 alt="{{ $product->name }}">
                        </div>
                    </div>

                    {{-- Buy Info Column --}}
                    <div class="flex flex-col space-y-4">
                        <div class="flex items-baseline justify-between">
                            <h1 class="text-4xl text-dark font-extrabold tracking-tight">{{ $product->name }}</h1>
                            <p class="text-3xl text-brand-primary font-extrabold">{{ number_format($product->price, 2) }}€</p>
                        </div>
                        
                        {{-- Available Colors --}}
                        <div>
                            <label class="block text-sm font-bold text-dark uppercase tracking-wider mb-3">
                                {{ __('Available Colors') }}
                            </label>
                            <div class="flex flex-wrap gap-2">
                                {{-- Current Color --}}
                                <div class="w-[60px] h-[50px] rounded-md border-2 border-dark overflow-hidden ring-2 ring-offset-1 ring-dark/10">
                                    <img src="{{ asset('images/products/' . $product->img) }}" class="w-full h-full object-cover" alt="current">
                                </div>

                                {{-- Variants: Links to Other Colors --}}
                                @foreach($variants as $variant)
                                    <a href="{{ route('shop.show', $variant->id) }}" class="w-14 h-12 rounded-md border border-gray-200 overflow-hidden hover:border-gray-400 transition-all opacity-70 hover:opacity-100">
                                        <img src="{{ asset('images/products/' . $variant->img) }}" class="w-full h-full object-cover" alt="variant">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        {{-- If product is in stock, show buy form --}}
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-bold text-dark uppercase tracking-wider mb-4">
                                        {{ __('Select size (EU)') }}
                                    </label>
                                    <div class="grid grid-cols-6 sm:grid-cols-8 gap-2">
                                        @foreach(['38', '39', '40', '41', '42', '43', '44', '45'] as $talla)
                                            <label class="relative">
                                                <input type="radio" name="size" value="{{ $talla }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                                                <div class="flex items-center justify-center h-10 w-full border-2 border-gray-200 rounded-md cursor-pointer transition-all peer-checked:border-white peer-checked:bg-dark peer-checked:text-bg-white hover:border-dark">
                                                    <span class="text-sm font-bold">{{ $talla }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                
                                {{-- Quantity + Add to Cart + Add to Wishlist --}}
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center">
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                            class="w-12 h-[48px] bg-bg-white text-center rounded-md text-dark border-2 border-[#e5e7eb] shadow-sm focus:border-brand-primary focus:ring-2 focus:ring-brand-primary no-spinner">
                                    </div>
                                    <button type="submit" class="w-full bg-brand-primary-soft text-white font-bold py-3 px-6 rounded-lg hover:bg-brand-primary transition duration-200 shadow-md">
                                        {{ __('Add to cart') }}
                                    </button>
                                    <button 
                                        type="button"
                                        aria-label="Add to wishlist"
                                        onclick="addToWishlist({{ $product->id }})">
                                        <i id="heart-{{ $product->id }}"
                                        class="fa-regular fa-heart text-[28px] hover:text-brand-primary transition-colors
                                        {{ isset(session('wishlist')[$product->id]) ? 'fa-solid text-red-500' : '' }}"></i>
                                    </button>
                                </div>
                            </form>
                            {{-- If product is out of stock, show out of stock message --}}
                        @else
                            <div class="p-4 bg-orange-50 border border-orange-200 rounded-xl">
                                <p class="text-sm text-orange-800 mb-3 font-medium flex items-center gap-2">
                                    <i class="fas fa-info-circle"></i> 
                                    {{ __('This model is temporarily out of stock.') }}
                                </p>
                                <form action="{{ route('products.simulated-alert', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white font-bold py-3 px-6 rounded-lg transition-all shadow-lg flex items-center justify-center gap-2">
                                        <i class="far fa-bell"></i>
                                        {{ __('Notify me when back in stock') }}
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- Back to shop link --}}
                        <a href="{{ route('shop.index') }}" class="mt-6 text-center text-sm text-dark hover:text-muted italic">
                            &larr; {{ __('Back to shop') }}
                        </a>
                    </div>
                </div>

                {{-- Inferior Grid - Detailed description --}}
                <div class="border-t border-gray-100 pt-10">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                        
                        {{-- Description --}}
                        <div class="md:col-span-2">
                            <h3 class="text-xl font-bold mb-4 uppercase tracking-wider text-dark italic">{{ __('Product information') }}</h3>
                            <div class="text-sm leading-relaxed text-muted space-y-6">
                                {{-- Display different descriptions according to the different categories --}}
                                @php
                                    $usage = $product->categories->where('type', 'usage')->first()->name ?? 'daily style';
                                    $brand = $product->categories->where('type', 'brand')->first()->name ?? 'our brand';
                                @endphp
                                
                                <p>
                                    {{ __('When talking about') }} {{ $brand }}, {{ __('one of the flagship models is undoubtedly') }} <strong>{{ $product->name }}</strong>, {{ __('the sneakers for') }} {{ strtolower($usage) }} {{ __('that cannot be missing in your wardrobe.') }}
                                    @if(strtolower($usage) == 'football')
                                        {{ __('Designed specifically to dominate the field, they offer unprecedented ball control.') }}
                                    @elseif(strtolower($usage) == 'running')
                                        {{ __('Optimized to cover kilometers, their cushioning technology protects every step you take.') }}
                                    @else
                                        {{ __('They combine the sporting heritage of') }} {{ $brand }} {{ __('with modern urban versatility.') }}
                                    @endif
                                </p>

                                <p>
                                    {{ __('Premium construction ensures these sneakers keep up with your daily pace, while the high-resistance rubber sole guarantees impeccable traction on any surface. A') }} <strong>{{ $brand }}</strong> {{ __('finish that makes a difference.') }}
                                </p>
                                {{-- Technical details --}}
                                <div class="mt-6 bg-bg-light p-4 rounded-lg">
                                    <h4 class="font-bold text-dark mb-2">{{ __('Composition and materials') }}</h4>
                                    <p class="text-sm text-muted">{{ __('Upper: Leather and Suede / Sole: Natural Rubber')}}</p>
                                    <p class="text-xs text-muted mt-2">{{ __('Code: ')}}{{ str_pad($product->id, 8, '0', STR_PAD_LEFT) }}_exclusive</p>
                                </div>
                            </div>
                        </div>

                        {{-- Supplier information, shipping and returns --}}
                        <div class="space-y-8">

                             {{-- Supplier information --}}
                            <div class="flex items-start gap-4">
                                <div class="bg-gray-100 p-1 rounded-full flex-shrink-0">
                                    <img src="{{ asset('images/SneakerCoreLogo.png') }}" class="w-9 h-9 object-contain" alt="{{ __('Logo') }}">
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm uppercase">{{ __('Sold and shipped by') }} <span class="text-brand-primary-soft">SNEAKERCORE</span></h4>
                                    <p class="text-xs text-muted">{{ __('100% original product with official store warranty.') }}</p>
                                </div>
                            </div>

                            {{-- Shipping information --}}
                            <div class="flex items-start gap-4">
                                <div class="bg-indigo-50 p-3 rounded-full text-indigo-600"><i class="fas fa-truck"></i></div>
                                <div>
                                    <h4 class="font-bold text-sm uppercase">{{ __('Free shipping') }}</h4>
                                    <p class="text-xs text-muted">{{ __('Orders +50€. Delivery 24/48h.') }}</p>
                                </div>
                            </div>

                            {{-- Returns information --}}
                            <div class="flex items-start gap-4">
                                <div class="bg-indigo-50 p-3 rounded-full text-indigo-600"><i class="fas fa-sync"></i></div>
                                <div>
                                    <h4 class="font-bold text-sm uppercase">{{ __('Returns') }}</h4>
                                    <p class="text-xs text-muted">{{ __('30 days for free exchanges.') }}</p>
                                </div>
                            </div>

                            {{-- Continue shopping --}}
                            <div class="pt-6 border-t border-gray-100">
                                <h4 class="text-md text-dark uppercase mb-3 tracking-widest font-bold">{{ __('Continue Shopping')}}</h4>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $brandCategory = $product->categories->where('type', 'brand')->first();
                                    @endphp

                                    {{-- If there is a brand category, show the "See more of 'brand' " button --}}
                                    @if ($brandCategory)
                                        <a href="{{ route('shop.index', ['brand' => $brandCategory->name]) }}" 
                                            class="inline-flex items-center group text-sm bg-light border-2 border-gray-200 px-6 py-3 rounded-lg font-bold uppercase text-brand-primary hover:border-brand-primary hover:bg-gray-50 transition-all duration-300  shadow-sm">
                                            <span>{{ __('See more of ') }} {{ $brandCategory->name }}</span>
                                            <i class="fas fa-arrow-right ml-2 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all"></i>
                                        </a>
                                        <a href="{{ route('shop.index') }}" 
                                            class="inline-flex items-center text-sm bg-light border-2 border-transparent px-6 py-3 rounded-lg font-bold uppercase hover:bg-gray-200 transition-all text-gray-500">
                                            <span>{{ __('View All')}}</span>
                                        </a>
                                        {{-- If there is no brand category, show the "View All" button --}}
                                    @else
                                        <a href="{{ route('shop.index') }}" 
                                            class="w-full text-center inline-flex items-center justify-center text-sm bg-gray-100 border-2 border-transparent px-6 py-4 rounded-lg font-bold uppercase hover:bg-gray-200 transition-all text-gray-500">
                                            <span>{{ __('View All') }}</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</x-app-layout>
