<x-app-layout>
    <x-slot name="title"> {{ __('Wishlist') }} </x-slot>

    <div class="bg-bg-white text-dark flex px-4 py-8 lg:p-8 items-start justify-center min-h-screen font-['Instrument_Sans']">

        <main class="w-full lg:max-w-6xl">

            {{-- Header --}}
            <div class="mb-12 text-center">
                <h1 class="text-4xl lg:text-5xl font-black tracking-tighter uppercase text-secondary">
                    {{ __('My Wishlist') }}
                </h1>
                <p class="mt-4 text-secondary-soft text-lg">
                    {{ __('Find your favorite sneakers here.') }}
                </p>
            </div>

            {{-- If wishlist is empty --}}
            @if($wishlistItems->isEmpty())
                <div class="text-center py-16">
                    <p class="text-gray-500 text-lg">
                        {{ __('Your wishlist is empty') }}
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    {{-- Wishlist Items --}}
                    @foreach($wishlistItems as $item)
                        <div id="wishlist-item-{{ $item['id'] }}" class="bg-input-bg border border-gray-100 rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                            {{-- Image --}}
                            <a href="{{ route('shop.show', $item['id']) }}">
                                <img
                                    src="{{ asset($item['img']) }}"
                                    alt="{{ $item['name'] }}"
                                    class="w-full h-56 object-contain p-4 bg-gray-50"
                                >
                            </a>

                            {{-- Info --}}
                            <div class="p-4">
                                <h2 class="font-semibold text-lg mb-1">
                                    {{ $item['name'] }}
                                </h2>

                                <p class="text-brand-primary font-bold mb-4">
                                    {{ $item['price'] }} €
                                </p>

                                <div class="flex items-center justify-between gap-2">
                                    {{-- See product --}}
                                    <a
                                        href="{{ route('shop.show', $item['id']) }}"
                                        class="flex-1 text-center bg-input-border hover:bg-bg-light text-sm py-2 rounded-lg transition"
                                    >
                                        {{ __('View') }}
                                    </a>

                                    {{-- Remove from wishlist --}}
                                    <button
                                        type="button"
                                        onclick="addToWishlist({{ $item['id'] }})"
                                        class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition"
                                        aria-label="Remove from wishlist"
                                    >
                                        <i class="fa-solid fa-heart-crack"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endforeach

                </div>
            @endif
        </main>
    </div>
</x-app-layout>
