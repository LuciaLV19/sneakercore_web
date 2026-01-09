<x-app-layout>
    <div class="flex min-h-screen bg-bg-light">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main wrapper --}}
        <main class="flex-1 p-10">

            {{-- Header --}}
            <header class="flex flex-col items-center text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight uppercase font-font-title text-main-text">
                    {{ __('Create User') }}
                </h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                    {{ __('Fill in the details to add a new user.') }}
                </p>
            </header>

            {{-- Form container --}}
            <section class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow flex flex-col gap-6">
                <div class="form-card"> 

                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf

                        {{-- Name and Password Fields --}}
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}:</label>
                                <input type="text" name="name" id="name" placeholder="{{ __('User Name') }}" value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Password') }}:</label>
                                <div class="password-wrapper">
                                    <input type="password" name="password" class="password-input" id="password" placeholder="{{ __('Password') }}" required>
                                    <span class="togglePassword">
                                        <i class="fa-regular fa-eye" class="eyeIcon"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">{{ __('Confirm Password') }}:</label>
                                <div class="password-wrapper">
                                    <input type="password" name="password_confirmation" class="password-input" id="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>
                                    <span class="togglePassword">
                                        <i class="fa-regular fa-eye" class="eyeIcon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Email and Role Fields --}}
                        <div class="form-row"> 
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}:</label>
                                <input type="email" name="email" id="email" placeholder="{{ __('User Email') }}" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="role">{{ __('Role') }}:</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="" disabled {{ old('role') === null ? 'selected' : '' }}>{{ __('Select a role') }}</option>
                                    <option value="0" {{ old('role') === '0' ? 'selected' : '' }}>{{ __('Client') }}</option>
                                    <option value="1" {{ old('role') === '1' ? 'selected' : '' }}>{{ __('Administrator') }}</option>
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
                            <a href="{{ route('admin.users.index') }}" class="btn-back">{{ __('Back to list')}}</a>
                            <button type="submit" class="btn">{{ __('Save User') }}</button>
                        </div>

                    </form>

                </div>
            </section>
        </main>
    </div>

    {{-- Toggle Password Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</x-app-layout>
