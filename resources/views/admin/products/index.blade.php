<x-app-layout>
    <div class="flex min-h-screen bg-bg-light">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main wrapper --}}
        <main class="flex-1 p-10">

            {{-- Page title --}}
            <header class="flex flex-col items-center text-center mb-10">
                <div>
                    <h1
                        class="text-3xl md:text-4xl font-bold tracking-tight uppercase font-font-title text-main-text"
                    >
                        SNEAKER<span class="text-brand-primary">CORE</span> — {{ __('Product Management') }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                        {{ __('Manage your product catalog. Add, edit and organize items for sale.') }}
                    </p>
                </div>
            </header>

            {{-- Main content card --}}
            <section class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow flex flex-col gap-6">

                {{-- Header actions --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

                    {{-- Search --}}
                    <form method="GET" class="flex items-center gap-3 w-full max-w-md">
                        <div class="relative w-full group">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-brand-primary"></i>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="{{ __('Search in stock...') }}"
                                class="w-full pl-10 pr-4 py-2 rounded-full bg-bg-light border border-transparent focus:border-brand-primary focus:ring-2 focus:ring-brand-primary-soft outline-none focus:bg-bg-white transition-all"
                            >
                        </div>

                        @if(request('search'))
                            <a href="{{ route('admin.products.index') }}"
                               class="text-sm text-gray-500 hover:text-brand-primary transition">
                                {{ __('Clean') }}
                            </a>
                        @endif
                    </form>

                    {{-- Create Product --}}
                    <a href="{{ route('admin.products.create') }}"
                       class="inline-flex items-center gap-2 bg-brand-primary text-white px-4 py-2 rounded-lg font-semibold hover:bg-brand-primary-soft transition">
                        + {{ __('Create Product') }}
                    </a>
                </div>

                {{-- Products table --}}
                <div class="overflow-x-auto rounded-xl border">
                    <table class="min-w-full text-base">
                        <thead class="bg-brand-secondary-soft text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">{{ __('Name') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Description') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Price') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Stock') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Image') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Categories') }}</th>
                                <th class="px-4 py-3 text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($products as $product)
                                <tr class="odd:bg-gray-50 dark:odd:bg-slate-800">

                                    {{-- Name --}}
                                    <td class="px-4 py-3 font-bold">{{ $product->name }}</td>

                                    {{-- Description --}}
                                    <td class="px-4 py-3 max-w-xs truncate" title="{{ $product->description }}">
                                        {{ $product->description }}
                                    </td>

                                    {{-- Price --}}
                                    <td class="px-4 py-3 font-semibold">{{ number_format($product->price, 2) }} €</td>

                                    {{-- Stock --}}
                                    <td class="px-4 py-3">
                                        @php
                                            $badge = $product->stock <= 0
                                                ? 'bg-red-500'
                                                : ($product->stock <= 5 ? 'bg-orange-400' : 'bg-green-500');
                                        @endphp
                                        <span class="text-white px-2 py-1 rounded text-base font-bold {{ $badge }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>

                                    {{-- Image --}}
                                    <td class="px-4 py-3">
                                        @if($product->img)
                                            <img
                                                src="{{ asset('images/products/' . $product->img) }}"
                                                alt="{{ $product->name }}"
                                                class="w-16 h-12 object-cover rounded"
                                            >
                                        @else
                                            <span class="text-gray-400 dark:text-gray-300">{{ __('No image') }}</span>
                                        @endif
                                    </td>

                                    {{-- Categories --}}
                                    <td class="px-4 py-3 text-gray-500 dark:text-gray-300">
                                        {{ $product->categories?->pluck('name')->implode(', ') ?: '-' }}
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-4 py-3">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                               class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-base font-semibold transition">
                                                {{ __('Edit') }}
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('admin.products.destroy', $product->id) }}"
                                                  onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="bg-red-400 hover:bg-red-500 text-white px-3 py-1 rounded text-base font-semibold transition">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $products->links() }}
                </div>

            </section>
        </main>
    </div>
</x-app-layout>
