<x-app-layout>
    <x-slot name="title">{{ __('My Orders') }}</x-slot>

    <div class="bg-bg-white text-dark flex px-4 py-8 lg:p-8 items-start justify-center min-h-screen font-['Instrument_Sans']">

        <main class="w-full lg:max-w-6xl">

            {{-- Header --}}
            <div class="mb-12 text-center">
                <h1 class="text-4xl lg:text-5xl font-black tracking-tighter uppercase text-secondary">
                    {{ __('My Orders') }}
                </h1>
                <p class="mt-4 text-secondary-soft text-lg">
                    {{ __('Track your purchases and review your order history.') }}
                </p>
            </div>

            {{-- Orders --}}
            @if($orders->isEmpty())
                <div class="bg-gray-50 border border-soft rounded-xl p-12 text-center shadow-sm">
                    <p class="text-secondary-soft text-lg mb-6">
                        {{ __('You have not placed any orders yet.') }}
                    </p>
                    <a href="{{ route('shop.index') }}"
                        class="inline-block bg-brand-primary text-white px-8 py-4 font-bold uppercase tracking-widest text-sm rounded-sm hover:brand-primary-soft transition-all">
                        {{ __('Go Shopping') }}
                    </a>
                </div>
            @else
                <div class="space-y-8">
                    @foreach($orders as $order)
                        <div class="border border-soft rounded-xl shadow-md overflow-hidden">

                            {{-- Order header --}}
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 bg-bg-light">
                                <div>
                                    <p class="text-xs uppercase tracking-widest text-secondary-soft font-bold">
                                        {{ __('Order') }} #{{ $order->id }}
                                    </p>
                                    <p class="text-sm text-secondary-soft mt-1">
                                        {{ __('Placed on') }} {{ $order->created_at->format('d M Y') }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-6">
                                    <span class="text-sm font-bold uppercase tracking-widest
                                        @if($order->status === 'paid') text-success
                                        @elseif($order->status === 'pending') text-warning
                                        @else text-brand-primary-soft @endif">
                                        {{ __($order->status) }}
                                    </span>

                                    <span class="text-lg font-black text-brand-primary">
                                        {{ number_format($order->total_amount, 2) }}€
                                    </span>
                                </div>
                            </div>

                            {{-- Order products --}}
                            <div class="divide-y divide-soft">
                                @foreach($order->items as $item)
                                    <div class="flex items-center gap-6 p-6">

                                        {{-- Image --}}
                                        <div class="w-24 h-24 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden">
                                            <img src="{{ asset('images/products/' . $item->product->img) }}"
                                                alt="{{ $item->product->name }}"
                                                class="object-contain w-full h-full p-3">
                                        </div>

                                        {{-- Info --}}
                                        <div class="flex-1">
                                            <h3 class="font-black uppercase tracking-tight text-secondary">
                                                {{ $item->product->name }}
                                            </h3>
                                            <p class="text-sm text-secondary-soft mt-1">
                                                {{ __('Size') }}: {{ $item->size }} · {{ __('Qty') }}: {{ $item->quantity }}
                                            </p>
                                        </div>

                                        {{-- Price --}}
                                        <div class="text-right font-bold text-secondary">
                                            {{ number_format($item->price, 2) }}€
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</x-app-layout>
