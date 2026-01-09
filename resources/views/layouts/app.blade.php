<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SneakerCore | @yield('title', __('Home'))</title>

        <!-- Theme Mode Script -->
        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        

    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">    
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            <!-- Page Content -->
            <main>
                <div id="notification-container" class="fixed top-5 left-1/2 z-[100] flex flex-col gap-3 w-full max-w-sm">
                    
                    {{-- PHP Alert: Success --}}
                    @if (session('success'))
                        <div class="notification-card bg-black text-white p-4 shadow-2xl rounded-xl border border-gray-800 flex items-center transform transition-all duration-500 translate-x-0">
                            <div class="flex-shrink-0 mr-3 text-green-400">
                                <i class="fa-solid fa-circle-check text-xl"></i>
                            </div>
                            <p class="text-[15px]">{{ session('success') }}</p>
                        </div>
                        @php session()->forget('success'); @endphp
                    @endif

                    {{-- PHP Alert: Error --}}
                    @if (session('error'))
                        <div class="notification-card bg-red-600 text-white p-4 shadow-2xl rounded-xl flex items-center transform transition-all duration-500">
                            <div class="flex-shrink-0 mr-3">
                                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                            </div>
                            <p class="text-[15px]">{{ session('error') }}</p>
                        </div>
                        @php session()->forget('error'); @endphp
                    @endif

                    {{-- PHP Alert: Info --}}
                    @if (session('info'))
                        <div class="notification-card bg-blue-500 text-white p-4 shadow-2xl rounded-xl flex items-center transform transition-all duration-500">
                            <div class="flex-shrink-0 mr-3">
                                <i class="fa-solid fa-circle-info text-xl"></i>
                            </div>
                            <p class="text-[15px]">{{ session('info') }}</p>
                        </div>
                        @php session()->forget('info'); @endphp
                    @endif
                </div>
                {{ $slot }}
            </main>
        </div>
        @include('layouts.footer')

        <script> // Messages for Feedback 
            window.i18n = {
                wishlistAdded: "{{ __('added to wishlist') }}",
                wishlistRemoved: "{{ __('removed from wishlist') }}",
                selectCategories: "{{ __('Select categories') }}"
            };
        </script>

    </body>
</html>
