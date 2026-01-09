<x-app-layout>
    <div class="flex min-h-screen bg-bg-light">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main wrapper --}}
        <main class="flex-1 p-10">

            {{-- Header --}}
            <header class="flex flex-col items-center text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight uppercase font-font-title text-main-text">
                    {{ __('Edit User') }}: {{ $user->name }}
                </h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                    {{ __('Update the user details below.') }}
                </p>
            </header>

            {{-- Form container --}}
            <section class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow flex flex-col gap-6">
                <div class="form-card">

                    <form action="{{ route('admin.users.update', $user) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')

                        {{-- Name Field --}}
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}:</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        {{-- Email and Role Fields --}}
                        <div class="form-row"> 
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}:</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="role">{{ __('Role') }}:</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="0" {{ old('role', $user->role) == 0 ? 'selected' : '' }}>{{ __('Client') }}</option>
                                    <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>{{ __('Admin') }}</option>
                                </select>
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
                            <a href="{{ route('admin.users.index') }}" class="btn-back">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn">{{ __('Update User') }}</button>
                        </div>

                    </form>
                </div>
            </section>
        </main>
    </div>
</x-app-layout>
