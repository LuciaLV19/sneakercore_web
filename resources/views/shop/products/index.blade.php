<x-app-layout>
    {{-- Shop catalog page --}}
    <div class="py-12 bg-bg-light min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">

            {{-- Filters sidebar --}}
            <div class="w-full md:w-64 flex-shrink-0">
                @include('shop.partials.sidebar')
            </div>

            {{-- Products section --}}
            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @forelse($products as $product)
                        {{-- Product card --}}
                        <a
                            href="{{ route('shop.show', $product->id) }}"
                            class="group bg-card-bg rounded-xl border border-border-soft overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col"
                        >

                            {{-- Product image --}}
                            <div class="relative aspect-[3/2] overflow-hidden bg-bg-light">
                                <img
                                    src="{{ asset('images/products/' . $product->img) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                >

                                {{-- Low stock badge --}}
                                @if($product->stock <= 5 && $product->stock > 0)
                                    <span class="low-stock-badge">
                                        {{ __('Last Units!') }}
                                    </span>
                                @endif

                                {{-- Sold out overlay --}}
                                @if($product->stock <= 0)
                                    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center">
                                        <span class="bg-white text-dark text-xs font-black px-3 py-1 rounded uppercase">
                                            {{ __('Sold Out') }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Product info --}}
                            <div class="p-5 flex flex-col justify-between flex-grow">
                                <h3 class="font-bold text-lg text-main-text group-hover:text-brand-primary transition-colors line-clamp-2">
                                    {{ $product->name }}
                                </h3>

                                <div class="mt-4 flex items-center justify-between">
                                    <p class="text-xl font-black text-main-text">
                                        {{ number_format($product->price, 2) }}€
                                    </p>

                                    {{-- Arrow hover indicator --}}
                                    <span class="text-brand-primary opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @empty
                        {{-- Empty results state --}}
                        <div class="col-span-full py-20 px-6 flex flex-col items-center justify-center text-center bg-card-bg rounded-2xl border border-dashed border-border-soft">
                            <div class="w-24 h-24 bg-bg-light rounded-full flex items-center justify-center mb-6 text-muted text-4xl">
                                <i class="fas fa-filter"></i>
                            </div>

                            <h3 class="text-2xl font-black uppercase tracking-tight text-main-text mb-3">
                                {{ __('No results found') }}
                            </h3>

                            <p class="text-base text-muted mb-8 max-w-sm">
                                {{ __("We couldn't find any products matching your current filters.") }}
                            </p>

                            {{-- Reset filters button --}}
                            <a
                                href="{{ route('shop.index') }}"
                                class="inline-flex items-center gap-2 bg-brand-secondary text-light px-8 py-3 rounded-full font-bold uppercase tracking-widest hover:bg-brand-primary transition-all text-xs"
                            >
                                <i class="fas fa-undo-alt text-xs"></i>
                                {{ __('Clear filters') }}
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-10 mb-20">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
