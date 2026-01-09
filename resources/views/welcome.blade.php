<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">{{ __('Home') }}</x-slot>

    <div class="bg-bg-white text-dark flex px-4 py-8 lg:p-8 items-center lg:justify-center min-h-screen flex-col font-['Instrument_Sans']">
        {{-- Hero Section --}}
        <main class="flex w-full flex-col lg:max-w-6xl lg:flex-row shadow-2xl rounded-none sm:rounded-xl overflow-hidden border border-soft">
            
            <div class="lg:w-3/5 bg-brand-secondary relative overflow-hidden group">
                <img src="{{ asset('images/jordan1jbalvin_home.png') }}" alt="Sneakers" class="object-cover w-full h-full opacity-80 group-hover:scale-105 transition-transform duration-700">
                <div class="absolute bottom-8 left-8">
                    <span class="bg-brand-primary text-white px-3 py-1 text-xs font-bold uppercase tracking-widest">{{ __('Limited Edition') }}</span>
                </div>
            </div>

            {{-- Eye-catching text --}}
            <div class="flex-1 p-8 lg:p-16 bg-bg-white flex flex-col justify-center">
                <h1 class="text-5xl font-black leading-none tracking-tighter text-secondary mb-6">
                    {{ __('MORE THAN') }} <br><span class="text-brand-primary-soft">{{ __('SNEAKERS') }}.</span>
                </h1>
                <p class="mb-8 text-secondary-soft text-lg leading-relaxed">
                    {{ __('An exclusive selection curated for streetwear lovers. Quality, authenticity, and the style that defines your path.') }} 
                </p>
                
                {{-- Buttons --}}
                <div class="flex flex-col gap-4">
                    <a href="/shop/91" class="w-full bg-brand-primary text-white text-center py-4 rounded-sm font-bold text-lg hover:brand-primary-soft shadow-lg transition-all transform hover:-translate-y-1">
                        {{ __('SHOP NOW') }}
                    </a>
                    <a href="{{ route ('shop.index') }}" class="w-full border border-soft text-secondary-soft text-center py-4 rounded-sm font-semibold hover:bg-border-soft transition-all">
                        {{ __('Explore Catalog') }}
                    </a>
                </div>

                <div class="mt-12 pt-8 border-t border-soft grid grid-cols-3 gap-2 text-[10px] font-bold uppercase tracking-widest text-secondary-soft">
                    <div class="flex items-center gap-2"><span>✔</span> {{ __('Authentic') }}</div>
                    <div class="flex items-center gap-2"><span>✔</span> {{ __('Premium') }}</div>
                    <div class="flex items-center gap-2"><span>✔</span> {{ __('24h Delivery') }} </div>
                </div>
            </div>
        </main>

        {{-- Buy for Gender --}}
        <section class="w-full lg:max-w-6xl mt-16 grid grid-cols-1 md:grid-cols-2 gap-6 px-4">
            {{-- Men Card --}}
            <a href="{{ route('shop.index', ['gender' => 'Hombre']) }}" class="relative h-[400px] group overflow-hidden rounded-xl">
                <img src="{{ asset('images/ui_lifestyle/men.png') }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                    <h3 class="text-white text-4xl font-black italic tracking-tighter uppercase">{{ __('Men') }}</h3>
                </div>
            </a>
            {{-- Women Card --}}
            <a href="{{ route('shop.index', ['gender' => 'Mujer']) }}" class="relative h-[400px] group overflow-hidden rounded-xl">
                <img src="{{ asset('images/ui_lifestyle/women.png') }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                    <h3 class="text-white text-4xl font-black italic tracking-tighter uppercase">{{ __('Women') }}</h3>
                </div>
            </a>
        </section>

        <section id="featured" class="w-full lg:max-w-6xl mt-20">
            <h2 class="text-center text-3xl font-bold tracking-[0.3em] uppercase mb-10 opacity-60">{{ __('LATEST DROPS')}}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 px-4">
                @foreach($latestProducts as $product)
                    <a href="{{ route('shop.show', $product->id) }}" class="group flex flex-col">
                        {{-- Sneakers Card --}}
                        <div class="aspect-square bg-gray-100 rounded-[2rem] overflow-hidden flex items-center justify-center relative transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                            
                            {{-- Badge --}}
                            <span class="absolute top-6 left-6 bg-black text-white text-[10px] font-black px-3 py-1 uppercase tracking-widest z-10">
                                {{ __('New') }}
                            </span>
                            {{-- Image --}}
                            <img src="{{ asset('images/products/' . $product->img) }}" 
                                alt="{{ $product->name }}"
                                class="w-full h-full object-contain p-10 group-hover:scale-110 transition-transform duration-700">
                        </div>

                        {{-- Product Info --}}
                        <div class="mt-6 px-2">
                            <div class="flex justify-between items-center mt-2">
                                <h3 class="font-black text-xl uppercase tracking-tighter text-secondary leading-tight">
                                    {{ $product->name }}
                                </h3>
                                <span class="font-black text-lg text-brand-primary">
                                    {{ number_format($product->price, 2) }}€
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Buy for Sport/Use --}}
        <section class="w-full lg:max-w-6xl mt-20 px-4">
            <h2 class="text-2xl font-black tracking-tighter mb-8 uppercase italic">{{ __('Buy for Sport/Use') }}</h2>
            <div class="flex flex-wrap overflow-x-auto no-scrollbar justify-around pb-4">
                @foreach($usages as $use)
                <a href="{{ route('shop.index', ['usage' => $use->name]) }}" class="flex flex-col items-center gap-3 min-w-[120px]">
                    {{-- Icon Card --}}
                    <div class="w-40 h-40 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border-2 border-transparent group-hover:brand-primary transition-all">
                        <img src="/images/sports/{{ strtolower($use->name) }}.png" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm font-bold uppercase tracking-widest">{{ __($use->name) }}</span>
                </a>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>