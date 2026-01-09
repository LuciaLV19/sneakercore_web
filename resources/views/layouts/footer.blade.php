<footer class="bg-bg-white border-t border-gray-100 font-['Instrument_Sans'] pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Principal Grid (4 columns) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            
            {{-- Column 1: Branding y RRSS --}}
            <div class="space-y-6">
                <div class="font-black text-2xl tracking-tighter text-dark">
                    SNEAKER<span class="text-brand-primary-soft">CORE</span>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed max-w-xs">
                    {{ __('Elevating your style since 2024. The best selection of limited sneakers and urban streetwear.') }}
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-brand-secondary hover:bg-brand-primary-soft hover:text-white transition-all">
                        <i class="fa-brands fa-instagram text-lg"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-brand-secondary hover:bg-brand-primary-soft hover:text-white transition-all">
                        <i class="fa-brands fa-tiktok text-lg"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-brand-secondary hover:bg-brand-primary-soft hover:text-white transition-all">
                        <i class="fa-brands fa-x-twitter text-lg"></i>
                    </a>
                </div>
            </div>

            {{-- Column 2: Shop --}}
            <div>
                <h4 class="font-black uppercase tracking-widest text-xs text-gray-400 mb-6">{{ __('Shop') }}</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('shop.index', ['gender' => 'Men']) }}" class="text-sm font-bold text-dark hover:text-brand-primary-soft transition-colors">{{ __('Men') }}</a></li>
                    <li><a href="{{ route('shop.index', ['gender' => 'Women']) }}" class="text-sm font-bold text-dark hover:text-brand-primary-soft transition-colors">{{ __('Women') }}</a></li>
                    <li><a href="{{ route('new-arrivals') }}" class="text-sm font-bold text-dark hover:text-brand-primary-soft transition-colors">{{ __('New Arrivals') }}</a></li>
                    <li><a href="#" class="text-sm font-bold text-brand-primary-soft hover:text-dark transition-colors">{{ __('Sale') }}</a></li>
                </ul>
            </div>

            {{-- Column 3: Support --}}
            <div>
                <h4 class="font-black uppercase tracking-widest text-xs text-gray-400 mb-6">{{ __('Support') }}</h4>
                <ul class="space-y-4">
                    <li><a href="#" class="text-sm font-bold text-dark hover:text-brand-primary-soft transition-colors">{{ __('Shipping Policy') }}</a></li>
                    <li><a href="#" class="text-sm font-bold text-dark hover:text-brand-primary-soft transition-colors">{{ __('Returns & Exchanges') }}</a></li>
                    <li><a href="#" class="text-sm font-bold text-dark hover:text-brand-primary-soft transition-colors">{{ __('Track Order') }}</a></li>
                    <li><a href="#" class="text-sm font-bold text-dark hover:text-brand-primary-soft transition-colors">{{ __('Contact Us') }}</a></li>
                </ul>
            </div>

            {{-- Column 4: Newsletter --}}
            <div>
                <h4 class="font-black uppercase tracking-widest text-xs text-gray-400 mb-6">{{ __('Stay in the loop') }}</h4>
                <p class="text-gray-500 text-sm mb-4">{{ __('Subscribe to get special offers and first look at new drops.') }}</p>
                <form class="relative">
                    <input type="email" placeholder="Email address" 
                           class="w-full bg-input-bg border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-brand-primary-soft">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 font-black text-xs uppercase text-brand-primary-soft hover:text-dark transition-colors px-2">
                        {{ __('Join') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Bottom line: Copyright and Payment Methods --}}
        <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">
                &copy; {{ date('Y') }} SNEAKERCORE. {{ __('All rights reserved.') }}
            </p>
            
            {{-- Payment Methods --}}
            <div class="flex items-center gap-4 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
                <i class="fa-brands fa-cc-visa text-2xl"></i>
                <i class="fa-brands fa-cc-mastercard text-2xl"></i>
                <i class="fa-brands fa-cc-apple-pay text-2xl"></i>
                <i class="fa-brands fa-cc-paypal text-2xl"></i>
            </div>
        </div>
    </div>
</footer>