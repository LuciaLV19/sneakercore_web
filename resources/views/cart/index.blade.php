<x-app-layout>
    <div class="bg-bg-white min-h-screen font-['Instrument_Sans']">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            {{-- Page Title --}}
            <h1 class="text-4xl font-black tracking-tighter uppercase mb-10">
                {{ __('Your Cart') }} <span class="text-gray-300">({{ count($cartItems) }})</span>
            </h1>

            {{-- Cart Items --}}
            <div class="flex flex-col lg:flex-row gap-12">
                
                <div class="flex-1">
                    @forelse($cartItems as $id => $details)
                        <div class="flex flex-col sm:flex-row gap-6 py-8 border-b border-gray-100 group">
                            <div class="w-full sm:w-40 h-40 bg-gray-50 rounded-xl overflow-hidden shrink-0">
                                <a href="{{ route('shop.show', $details['id']) }}" class="block w-full h-full cursor-pointer">
                                    <img src="{{ asset('images/products/' . ($details['img'] ?? 'default-sneaker.png')) }}"
                                    class="w-full h-full object-contain p-4">
                                </a>
                            </div>

                            <div class="flex flex-col justify-between flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-xl font-black uppercase tracking-tighter text-dark leading-tight">
                                            <a href="{{ route('shop.show', $details['id']) }}">{{ $details['name'] }}</a>
                                        </h3>
                                        <p class="text-gray-500 text-sm font-bold uppercase mt-1">{{ $details['brand'] ?? 'Sneakers' }}</p>
                                        <p class="text-gray-400 text-xs mt-1">{{ __('Size') }}: <span class="text-dark font-bold">{{ $details['size'] }}</span></p>
                                    </div>
                                    <p class="text-xl font-black text-dark">{{ number_format($details['price'], 2) }}€</p>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center border border-gray-200 rounded-full px-4 py-1">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="action" value="decrement">
                                            <button type="submit" class="text-gray-400 hover:text-black font-bold">-</button>
                                        </form>

                                        <span class="mx-4 font-black text-sm">{{ $details['quantity'] }}</span>

                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="action" value="increment">
                                            <button type="submit" class="text-gray-400 hover:text-black font-bold">+</button>
                                        </form>
                                    </div>

                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors ">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Empty state --}}
                        <div class="py-20 text-center">
                            <i class="fa-solid fa-bag-shopping text-6xl text-gray-100 mb-6"></i>
                            <p class="text-gray-500 font-bold uppercase tracking-widest">{{ __('Your cart is empty') }}</p>
                            <a href="{{ route('shop.index') }}" class="inline-block mt-6 bg-black text-white px-10 py-4 font-black uppercase tracking-tighter hover:bg-brand-primary transition-all">
                                {{ __('Start shopping') }}
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- Order Summary --}}
                <div class="lg:w-[400px]">
                    <div class="bg-bg-light rounded-3xl p-8 sticky top-28">
                        <h2 class="text-2xl font-black uppercase tracking-tighter mb-3">{{ __('Order sumary') }}</h2>
                        {{-- Free shipping progress --}}
                        @if($howMuchFor > 0)
                            <div class="mb-4 p-4 bg-red-50 rounded-2xl border border-red-100 dark:bg-red-950 dark:border-red-900">
                                <p class="text-xs font-bold text-red-800 dark:text-red-300 uppercase tracking-widest text-center flex items-center justify-center gap-2">
                                    <span class="text-lg">{{ number_format($howMuchFor, 2) }}€ </span><span class="text-3xl">+</span> {{ __(' from free shipping!') }}
                                </p>
                            </div>
                        @endif
                        {{-- Pricing Details --}}
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-gray-600 font-bold uppercase text-xs tracking-widest">
                                <span>{{ __('Subtotal') }}</span>
                                <span>{{ number_format($subtotal, 2) }}€</span>
                            </div>
                            <div class="flex justify-between text-gray-600 font-bold uppercase text-xs tracking-widest">
                                <span>{{ __('Shipping') }}</span>
                                <span>{{ $shipping == 0 ? __('Free') : number_format($shipping, 2) . '€' }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-4 flex justify-between items-end">
                                <span class="text-sm font-black uppercase">{{ __('Total') }}</span>
                                <span class="text-3xl font-black leading-none tracking-tighter">{{ number_format($total, 2) }}€</span>
                            </div>
                        </div>
                        {{-- Checkout Button --}}
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <button type="submit" id="checkout-button" class="block w-full bg-black text-white text-center py-5 rounded-full font-black text-lg uppercase tracking-tighter hover:bg-brand-primary shadow-xl shadow-black/10 transition-all transform hover:-translate-y-1">
                                {{ __('Checkout') }}
                            </button>
                        </form>

                        {{-- Payment Methods & Security Info --}}
                        <div class="mt-8 grid grid-cols-4 gap-4 grayscale opacity-50">
                            <i class="fa-brands fa-cc-visa text-2xl"></i>
                            <i class="fa-brands fa-cc-mastercard text-2xl"></i>
                            <i class="fa-brands fa-cc-paypal text-2xl"></i>
                            <i class="fa-brands fa-cc-apple-pay text-2xl"></i>
                        </div>
                        
                        <div class="mt-8 p-4 bg-bg-white rounded-xl border border-white">
                            <p class="text-[10px] font-bold text-gray-400 uppercase leading-relaxed">
                                <i class="fa-solid fa-shield-check mr-1"></i> {{ __('Secure payments and free returns for 30 days.') }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>