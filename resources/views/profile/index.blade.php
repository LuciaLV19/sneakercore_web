<x-app-layout>
    {{-- Page header --}}
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <i class="fas fa-user-circle text-2xl text-gray-600 dark:text-gray-400"></i>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Account') }}
            </h2>
        </div>
    </x-slot>

    {{-- Page wrapper --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Welcome message --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8 p-6 border-l-4 border-brand-primary">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                    {{ __('Welcome back, :name!', ['name' => Auth::user()->name]) }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('From here you can manage your orders, addresses and account security.') }}
                </p>
            </div>
            {{-- Profile options --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Orders --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition hover:shadow-md">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-box-open text-blue-600 dark:text-blue-300 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ __('My Orders') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ __('Track your shipments and review your invoices.') }}</p>
                    <a href="{{ route('orders.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-semibold text-sm">
                        {{ __('View history') }} <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

                {{-- Addresses --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition hover:shadow-md">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-map-marker-alt text-green-600 dark:text-green-300 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ __('Addresses') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ __('Manage your delivery points for faster checkouts.') }}</p>
                    <a href="{{ route('profile.edit') }}#address-section" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-semibold text-sm">
                        {{ __('Edit addresses') }} <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

                {{-- Profile & Security --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition hover:shadow-md">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-user-cog text-purple-600 dark:text-purple-300 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ __('Profile & Security') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ __('Update your password, email and account preferences.') }}</p>
                    <a href="{{ route('profile.edit') }}#security-section" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-semibold text-sm">
                        {{ __('Account settings') }} <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

                {{-- Wishlist --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition hover:shadow-md">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-heart text-red-600 dark:text-red-300 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ __('Wishlist') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ __('Quick access to the sneakers you love the most.') }}</p>
                    <a href="{{ route('wishlist.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-semibold text-sm">
                        {{ __('View favorites') }} <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>