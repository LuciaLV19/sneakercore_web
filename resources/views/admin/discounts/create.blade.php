<x-app-layout>
    <div class="flex min-h-screen bg-bg-light">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main wrapper --}}
        <main class="flex-1 p-10">

            {{-- Header --}}
            <header class="flex flex-col items-center text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight uppercase font-font-title text-main-text">
                    {{ __('Create Discount') }}
                </h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                    {{ __('Fill in the details to add a new discount.') }}
                </p>
            </header>

            {{-- Form container --}}
            <section class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow flex flex-col gap-6">
                <div class="form-card"> 

                    <form action="{{ route('admin.discounts.store') }}" method="POST">
                        @csrf

                        {{-- Nombre y Porcentaje --}}
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">{{ __('Discount Name') }}</label>
                                <input type="text" name="name" id="name" placeholder="Ej: NUEVO10" value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="percentage">{{ __('Percentage') }}</label>
                                <div class="percentage-wrapper">
                                    <input type="number" name="percentage" id="percentage" value="{{ old('percentage') }}" min="0" max="100" placeholder="0 - 100" required>
                                    <span class="icon">%</span>
                                </div>
                            </div>
                        </div>

                        {{-- Error Messages --}}
                        @if ($errors->any())
                        <div class="text-red-600 mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        {{-- Form Actions --}}
                        <div class="form-actions">
                            <a href="{{ route('admin.discounts.index') }}" class="btn-back">{{ __('Back to list') }}</a>
                            <button type="submit" class="btn">{{ __('Save Discount') }}</button>
                        </div>

                    </form>

                </div>
            </section>

        </main>
    </div>
</x-app-layout>
