<x-app-layout>
    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="flex min-h-screen bg-bg-light">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main wrapper --}}
        <main class="flex-1 p-10">

            {{-- Page title --}}
            <header class="flex flex-col items-center text-center mb-10">
                <div>
                    <h1
                        class="text-3xl md:text-4xl font-bold tracking-tight uppercase font-font-title text-main-text">
                        SNEAKER<span class="text-brand-primary">CORE</span> — {{ __('Dashboard') }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                        {{ __('Monitor key metrics and get a quick overview of your store performance.') }}
                    </p>
                </div>
            </header>

            {{-- Main content card --}}
            <section class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow flex flex-col gap-6">

                {{-- Stats cards row --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Total sales --}}
                    <div class="bg-bg-light p-6 rounded-2xl shadow flex flex-col">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                            {{ __('Total Sales') }}
                        </span>
                        <div class="text-2xl font-bold mt-2">€{{ number_format(\App\Models\Order::sum('total_amount'), 2) }}</div>
                    </div>

                    {{-- Products in stock --}}
                    <div class="bg-bg-light dark:bg-slate-800 p-6 rounded-2xl shadow flex flex-col">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                            {{ __('Products in Stock') }}
                        </span>
                        <div class="text-2xl font-bold mt-2">{{ \App\Models\Product::count() }}</div>
                    </div>

                    {{-- New orders --}}
                    <div class="bg-bg-light dark:bg-slate-800 p-6 rounded-2xl shadow flex flex-col">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                            {{ __('New Orders') }}
                        </span>
                        <div class="text-2xl font-bold mt-2">{{ \App\Models\Order::where('status', 'pending')->count() }}</div>
                    </div>

                </div>

                {{-- Charts grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Sales vs Visits (bar) --}}
                    <div class="bg-bg-light dark:bg-slate-800 p-6 rounded-2xl shadow flex flex-col">
                        <h3 class="font-bold mb-4">{{ __('Sales vs Visits') }}</h3>
                        <div class="flex-1">
                            <canvas id="salesChart" aria-label="{{ __('Sales vs Visits chart') }}" role="img" class="w-full h-64"></canvas>
                        </div>
                    </div>

                    {{-- Order status (doughnut) --}}
                    <div class="bg-bg-light dark:bg-slate-800 p-6 rounded-2xl shadow flex flex-col">
                        <h3 class="font-bold mb-4">{{ __('Order Status') }}</h3>
                        <div class="flex-1">
                            <canvas id="orderChart" aria-label="{{ __('Order status chart') }}" role="img" class="w-full h-64"></canvas>
                        </div>
                    </div>

                    {{-- Sales by category (polar area) --}}
                    <div class="bg-bg-light dark:bg-slate-800 p-6 rounded-2xl shadow flex flex-col">
                        <h3 class="font-bold mb-4">{{ __('Sales by Category') }}</h3>
                        <div class="flex-1">
                            <canvas id="categoryChart" aria-label="{{ __('Sales by category chart') }}" role="img" class="w-full h-64"></canvas>
                        </div>
                    </div>

                </div>

            </section>
        </main>
    </div>

    {{-- Charts scripts --}}
    <script>
        // Helper for legend label color based on theme
        const legendLabelColor = document.documentElement.classList.contains('dark') ? '#9ca3af' : '#111827';

        // Order status (doughnut)
        (function () {
            const ctx = document.getElementById('orderChart')?.getContext('2d');
            if (!ctx) return;
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [ '{{ __("Sales") }}', '{{ __("Products") }}', '{{ __("Revenue") }}' ],
                    datasets: [{
                        data: [68, 25, 14],
                        backgroundColor: ['#6b1616', '#3b82f6', '#10b981'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom',
                            labels: { color: legendLabelColor }
                        },
                        tooltip: { enabled: true }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        })();

        // Sales vs Visits (bar)
        (function () {
            const ctx = document.getElementById('salesChart')?.getContext('2d');
            if (!ctx) return;
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['{{ __("Jan") }}', '{{ __("Feb") }}', '{{ __("Mar") }}', '{{ __("Apr") }}', '{{ __("May") }}', '{{ __("Jun") }}'],
                    datasets: [
                        {
                            label: '{{ __("Sales") }}',
                            data: [12, 19, 3, 5, 2, 3],
                            backgroundColor: '#fd7e14'
                        },
                        {
                            label: '{{ __("Visits") }}',
                            data: [22, 29, 13, 15, 12, 13],
                            backgroundColor: '#3b82f6'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, ticks: { color: legendLabelColor } },
                        x: { ticks: { color: legendLabelColor } }
                    },
                    plugins: {
                        legend: { labels: { color: legendLabelColor } }
                    }
                }
            });
        })();

        // Sales by Category (polarArea)
        (function () {
            const ctx = document.getElementById('categoryChart')?.getContext('2d');
            if (!ctx) return;
            new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: [
                        '{{ __("Men") }}','{{ __("Women") }}','{{ __("Children") }}',
                        '{{ __("Casual") }}','{{ __("Running") }}','{{ __("Basketball") }}',
                        '{{ __("Training") }}','{{ __("Football") }}','{{ __("Skate") }}',
                        '{{ __("Nike") }}','{{ __("Jordan") }}','{{ __("Adidas") }}',
                        '{{ __("Puma") }}','{{ __("Reebok") }}','{{ __("New Balance") }}',
                        '{{ __("Converse") }}','{{ __("Lacoste") }}','{{ __("Vans") }}'
                    ],
                    datasets: [{
                        data: [30,45,15,10,20,25,5,15,10,50,30,25,20,10,15,5,10,8],
                        backgroundColor: [
                            '#3b82f6','#3b82f6','#3b82f6',
                            '#34d399','#34d399','#34d399','#34d399','#34d399','#34d399',
                            '#facc15','#facc15','#facc15','#facc15','#facc15','#facc15','#facc15','#facc15','#facc15'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { color: legendLabelColor }
                        }
                    }
                }
            });
        })();
    </script>

</x-app-layout>
