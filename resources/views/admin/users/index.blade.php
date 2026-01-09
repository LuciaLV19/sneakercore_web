<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 dark:bg-slate-800">

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
                        SNEAKER<span class="text-brand-primary">CORE</span> — {{ __('User Management') }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                        {{ __('View and manage registered customers and their account details.') }}
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
                                placeholder="{{ __('Search users...') }}"
                                class="w-full pl-10 pr-4 py-2 rounded-full bg-bg-light border border-transparent focus:border-brand-primary focus:ring-2 focus:ring-brand-primary-soft outline-none focus:bg-bg-white transition-all"
                            >
                        </div>

                        @if(request('search'))
                            <a href="{{ route('admin.users.index') }}"
                               class="text-sm text-gray-500 hover:text-brand-primary transition">
                                {{ __('Clean') }}
                            </a>
                        @endif
                    </form>

                    {{-- Create User --}}
                    <a href="{{ route('admin.users.create') }}"
                       class="inline-flex items-center gap-2 bg-brand-primary text-white px-4 py-2 rounded-lg font-semibold hover:bg-brand-primary-soft transition">
                        + {{ __('Create User') }}
                    </a>
                </div>

                {{-- Users table --}}
                <div class="overflow-x-auto rounded-xl border">
                    <table class="min-w-full text-base">
                        <thead class="bg-brand-secondary-soft text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">{{ __('Name') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Email') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Role') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Registered at') }}</th>
                                <th class="px-4 py-3 text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($users as $user)
                                <tr class="odd:bg-gray-50 dark:odd:bg-slate-800">

                                    {{-- User ID --}}
                                    <td class="px-4 py-3 font-semibold">#{{ $user->id }}</td>

                                    {{-- Name --}}
                                    <td class="px-4 py-3 font-bold">{{ $user->name }}</td>

                                    {{-- Email --}}
                                    <td class="px-4 py-3">{{ $user->email }}</td>

                                    {{-- Role --}}
                                    <td class="px-4 py-3">
                                        @if($user->role == 1)
                                            <span class="bg-brand-primary text-white px-2 py-1 rounded text-base font-bold">
                                                {{ __('Admin') }}
                                            </span>
                                        @else
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-base font-bold">
                                                {{ __('Customer') }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Registration date --}}
                                    <td class="px-4 py-3 text-gray-500 dark:text-gray-300">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-4 py-3">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                               class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-base font-semibold transition">
                                                {{ __('Edit') }}
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('admin.users.destroy', $user) }}"
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
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-300">
                                        {{ __('No users found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $users->links() }}
                </div>

            </section>
        </main>
    </div>
</x-app-layout>
