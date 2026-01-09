<x-app-layout>
    <div class="flex min-h-screen bg-bg-light">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main wrapper --}}
        <main class="flex-1 p-10">

            {{-- Page title --}}
            <header class="flex flex-col items-center text-center mb-10">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight uppercase font-font-title text-main-text">
                        SNEAKER<span class="text-brand-primary">CORE</span> — {{ __('Shipping and Rates') }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                        {{ __('Control shipping costs and profits. Adjust base rates and the minimum for free shipping.') }}
                    </p>
                </div>
            </header>

            {{-- Main content card --}}
            <section class="max-w-7xl mx-auto bg-white dark:bg-slate-900 rounded-2xl p-6 shadow flex flex-col gap-6">

                {{-- Metrics cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Current shipping cost --}}
                    <div class="bg-brand-primary text-white p-6 rounded-2xl shadow flex flex-col">
                        <p class="text-xs font-bold uppercase tracking-widest mb-1">{{ __('Current shipping cost') }}</p>
                        <h3 class="text-3xl font-bold">{{ number_format($settings->shipping_cost, 2) }}€</h3>
                    </div>

                    {{-- Free shipping threshold --}}
                    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow border border-gray-200 dark:border-gray-700 flex flex-col">
                        <p class="text-xs font-bold uppercase tracking-widest mb-1 text-gray-500 dark:text-gray-400">{{ __('Free shipping from') }}</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($settings->free_shipping_min, 2) }}€</h3>
                    </div>
                </div>

                {{-- Edit form --}}
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow border border-gray-200 dark:border-gray-700 flex flex-col gap-6">
                    <form action="{{ route('admin.shipping.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Inputs --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label for="shipping_cost" class="text-sm font-bold uppercase tracking-widest text-gray-900 dark:text-gray-100">
                                    {{ __('New shipping cost (€)') }}
                                </label>
                                <input type="number" name="shipping_cost" id="shipping_cost"
                                       value="{{ old('shipping_cost', $settings->shipping_cost ?? 0) }}"
                                       step="0.01" required
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-slate-900 focus:border-brand-primary focus:ring-0 font-bold transition">
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="free_shipping_min" class="text-sm font-bold uppercase tracking-widest text-gray-900 dark:text-gray-100">
                                    {{ __('New threshold for free shipping (€)') }}
                                </label>
                                <input type="number" name="free_shipping_min" id="free_shipping_min"
                                       value="{{ old('free_shipping_min', $settings->free_shipping_min ?? 0) }}"
                                       step="0.01"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-slate-900 focus:border-brand-primary focus:ring-0 font-bold transition">
                            </div>
                        </div>

                        {{-- Footer: error messages + submit --}}
                        <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-6">
                            <div class="flex-1">
                                @if ($errors->any())
                                    <ul class="text-red-500 text-xs font-bold uppercase tracking-tight space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-xs text-gray-400 italic flex items-center gap-1">
                                        <i class="fas fa-info-circle mr-1"></i> {{ __('Changes will apply to all new orders.') }}
                                    </p>
                                @endif
                            </div>

                            <div>
                                <button type="submit" class="bg-brand-primary text-white px-10 py-4 rounded-full font-bold uppercase text-xs tracking-widest hover:bg-brand-primary-soft hover:scale-105 transition shadow-lg">
                                    {{ __('Save Settings') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

            </section>
        </main>
    </div>
</x-app-layout>
