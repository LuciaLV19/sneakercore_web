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
                        SNEAKER<span class="text-brand-primary">CORE</span> — {{ __('Order Management') }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                        {{ __('Overview of recent orders and quick actions.') }}
                    </p>
                </div>
            </header>

            {{-- Main content card --}}
            <section class="max-w-7xl mx-auto bg-white dark:bg-slate-900 rounded-2xl p-6 shadow flex flex-col gap-6">

                {{-- Filters / Search --}}
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <form action="" method="GET" class="flex items-center gap-3 w-full md:w-2/3">

                        <input
                            type="search"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="{{ __('Search by ID, client, email, product...') }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-bg-light dark:bg-slate-800 focus:border-brand-primary focus:ring-2 focus:ring-brand-primary-soft outline-none transition"
                        />

                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-bg-light dark:bg-slate-800 focus:border-brand-primary focus:ring-2 focus:ring-brand-primary-soft outline-none transition"
                        >
                            <option value="">{{ __('All statuses') }}</option>
                            <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>⏳ {{ __('Processing') }}</option>
                            <option value="Shipped" {{ request('status') == 'Shipped' ? 'selected' : '' }}>🚚 {{ __('Shipped') }}</option>
                            <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>✅ {{ __('Delivered') }}</option>
                            <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>❌ {{ __('Cancelled') }}</option>
                        </select>
                    </form>

                    <div class="flex gap-3">
                        <a
                            href="{{ route('admin.orders.index', array_merge(request()->query(), ['sort' => 'newest'])) }}"
                            class="px-3 py-2 text-base rounded-lg bg-bg-light dark:bg-slate-800 text-gray-500 hover:text-brand-primary transition"
                        >
                            {{ __('Newest') }}
                        </a>
                        <a
                            href="{{ route('admin.orders.index', array_merge(request()->query(), ['sort' => 'highest'])) }}"
                            class="px-3 py-2 text-base rounded-lg bg-bg-light dark:bg-slate-800 text-gray-500 hover:text-brand-primary transition"
                        >
                            {{ __('Highest total') }}
                        </a>
                    </div>
                </div>

                {{-- Orders grid --}}
                <div class="grid gap-6">
                    @forelse($orders as $order)

                        {{-- Single order card --}}
                        <article class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-5 md:p-6 shadow hover:shadow-lg transition flex flex-col gap-4">

                            {{-- Header row --}}
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-lg font-bold font-font-title text-main-text">
                                        {{ __('Order') }} #{{ $order->id }}
                                    </h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>

                                {{-- Status + total --}}
                                <div class="flex items-center gap-3">
                                    @php $s = $order->status; @endphp
                                    <span class="text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide
                                        {{ $s == 'Processing' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $s == 'Shipped' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $s == 'Delivered' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ $s == 'Cancelled' ? 'bg-rose-100 text-rose-700' : '' }}
                                    ">
                                        {{ __($order->status) }}
                                    </span>

                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Total') }}</p>
                                        <p class="text-lg font-extrabold text-brand-primary">
                                            €{{ number_format($order->total_amount, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Content: products + customer --}}
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 items-start">

                                {{-- Products list --}}
                                <div class="md:col-span-2">
                                    <p class="text-sm font-semibold uppercase text-gray-500 dark:text-gray-400 mb-2">{{ __('Products') }}</p>
                                    <ul class="divide-y divide-gray-100 dark:divide-gray-700 rounded-lg overflow-hidden">
                                        @foreach($order->items as $item)
                                            <li class="flex items-center justify-between py-3">
                                                <div class="flex items-center gap-3">
                                                    <img
                                                        src="{{ $item->product->thumbnail_url ?? asset('images/products/' . $item->product->img) }}"
                                                        alt="{{ $item->product->name ?? 'Product Image' }}"
                                                        class="w-32 h-24 rounded-md object-cover border border-gray-200 dark:border-gray-700"
                                                    />
                                                    <div>
                                                        <p class="text-base font-semibold">{{ $item->product->name }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($item->product->short_description ?? '', 60) }}</p>
                                                    </div>
                                                </div>

                                                <div class="text-right">
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">x{{ $item->quantity }}</p>
                                                    <p class="text-base font-semibold">€{{ number_format($item->price, 2) }}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{-- Customer & actions --}}
                                <aside class="md:col-span-1 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                                    <p class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 mb-2">{{ __('Customer') }}</p>
                                    <p class="text-base font-semibold">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->user->email }}</p>

                                    <div class="mt-4">
                                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <label class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 mb-1 block">{{ __('Change status') }}</label>
                                            <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-bg-light dark:bg-slate-800 focus:border-brand-primary focus:ring-2 focus:ring-brand-primary-soft outline-none transition">
                                                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>{{ __('Processing') }}</option>
                                                <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>{{ __('Shipped') }}</option>
                                                <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                                                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                                            </select>
                                        </form>
                                    </div>
                                </aside>

                            </div>
                        </article>

                    @empty
                        {{-- Empty state --}}
                        <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-8 text-center">
                            <p class="text-lg font-semibold text-gray-500 dark:text-gray-400">{{ __('No orders found.') }}</p>
                            <p class="mt-2 text-base text-gray-500 dark:text-gray-400">{{ __('When orders arrive they will appear here for management.') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="pt-4">
                    {{ $orders->appends(request()->query())->onEachSide(1)->links() }}
                </div>

            </section>
        </main>
    </div>
</x-app-layout>
