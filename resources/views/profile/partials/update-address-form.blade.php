<section>
    <header>
        <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">
            {{ __('My Saved Addresses') }}
        </h2>
    </header>

    {{-- List of saved addresses --}}
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($user->addresses as $address)
            <form method="POST" action="{{ route('profile.address.default', $address->id) }}" class="w-full">
                @csrf
                @method('patch')
                
                <button type="submit" class="w-full text-left focus:outline-none group">
                    <div class="relative p-4 border-2 rounded-xl dark:bg-gray-800 transition-all {{ $address->is_default ? 'border-muted bg-muted/5' : 'border-gray-100 hover:border-gray-300' }}">
                        
                        @if($address->is_default)
                            <span class="absolute -top-3 left-4 bg-muted text-white text-[11px] font-semibold px-2 py-0.5 rounded uppercase">
                                {{ __('Default') }}
                            </span>
                        @endif
                        
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $address->address_line }}</p>
                                <p class="text-xs text-gray-500">{{ $address->city }}, {{ $address->postal_code }}</p>
                            </div>
                            @if($address->is_default)
                                <i class="fa-solid fa-circle-check text-muted text-sm"></i>
                            @endif
                        </div>
                    </div>
                </button>
            </form>
        @empty
            <p class="text-sm text-gray-500 italic">{{ __('No addresses saved yet.') }}</p>
        @endforelse
    </div>

    <hr class="my-8 border-gray-100 dark:border-gray-700">

    {{-- Add new address --}}
    <header>
        <h3 class="text-md font-bold uppercase tracking-wider text-gray-900 dark:text-gray-100">
            {{ __('Add New Address') }}
        </h3>
    </header>

    <form method="post" action="{{ route('profile.address.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Address --}}
        <div>
            <x-input-label for="address_line" :value="__('Address')" />
            <x-text-input id="address_line" name="address_line" type="text" 
                class="mt-1 block w-full" 
                :value="old('address_line', $user->address->address_line ?? '')" 
                required autocomplete="street-address" />
            <x-input-error class="mt-2" :messages="$errors->get('address_line')" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            {{-- City --}}
            <div>
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" name="city" type="text" 
                    class="mt-1 block w-full" 
                    :value="old('city', $user->address->city ?? '')" 
                    required autocomplete="address-level2" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>

            {{-- Postal Code --}}
            <div>
                <x-input-label for="postal_code" :value="__('Postal Code')" />
                <x-text-input id="postal_code" name="postal_code" type="text" 
                    class="mt-1 block w-full" 
                    :value="old('postal_code', $user->address->postal_code ?? '')" 
                    required 
                    pattern="[0-9]{5}"
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    autocomplete="postal-code" />
                <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
            </div>
        </div>

        {{-- Country --}}
        <div>
            <x-input-label for="country" :value="__('Country')" />
            <select id="country" name="country" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="Spain" {{ old('country', $user->address->country ?? '') == 'Spain' ? 'selected' : '' }}>{{ __('Spain')}}</option>
                <option value="Portugal" {{ old('country', $user->address->country ?? '') == 'Portugal' ? 'selected' : '' }}>{{ __('Porugal')}}</option>
                <option value="France" {{ old('country', $user->address->country ?? '') == 'France' ? 'selected' : '' }}>{{ __('France')}}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('country')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Address') }}</x-primary-button>

            {{-- Pequeño mensaje de confirmación que desaparece solo --}}
            @if (session('status') === 'address-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>