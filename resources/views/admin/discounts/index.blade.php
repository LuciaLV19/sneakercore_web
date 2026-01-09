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
                        SNEAKER<span class="text-brand-primary">CORE</span> — {{ __('Discounts') }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                        {{ __('Manage your store discounts. Create, edit or delete discounts as needed.') }}
                    </p>
                </div>
            </header>

            {{-- Main content card --}}
            <section class="max-w-7xl mx-auto bg-white dark:bg-slate-900 rounded-2xl p-6 shadow flex flex-col gap-6">

                {{-- Actions --}}
                <div class="flex justify-end">
                    <a href="{{ route('admin.discounts.create') }}"
                       class="bg-brand-primary text-white px-5 py-2 rounded-lg font-semibold hover:bg-brand-primary-soft transition">
                        + {{ __('Create Discount') }}
                    </a>
                </div>

                {{-- Discounts table --}}
                <div class="overflow-x-auto rounded-xl border">
                    <table class="min-w-full text-base">
                        <thead class="bg-brand-secondary-soft text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">{{ __('Name') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Percentage') }}</th>
                                <th class="px-4 py-3 text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($discounts as $discount)
                                <tr class="odd:bg-gray-50 dark:odd:bg-slate-800">

                                    {{-- Discount ID --}}
                                    <td class="px-4 py-3 font-semibold">
                                        #{{ $discount->id }}
                                    </td>

                                    {{-- Discount Name --}}
                                    <td class="px-4 py-3 font-bold">
                                        {{ $discount->name }}
                                    </td>

                                    {{-- Discount Percentage --}}
                                    <td class="px-4 py-3">
                                        {{ $discount->percentage }}%
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-2">
                                            {{-- Edit button --}}
                                            <a href="{{ route('admin.discounts.edit', $discount) }}"
                                               class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-base font-semibold">
                                                {{ __('Edit') }}
                                            </a>

                                            {{-- Delete button --}}
                                            <form action="{{ route('admin.discounts.destroy', $discount) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('{{ __('Delete discount?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-400 hover:bg-red-500 text-white px-3 py-1 rounded text-base font-semibold">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        {{ __('No discounts found. Create a new one to get started.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </section>
        </main>
    </div>
</x-app-layout>
