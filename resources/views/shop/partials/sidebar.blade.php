<aside class="bg-bg-white p-6 rounded-xl border border-[#edf2f7]">
    {{-- Search Form --}}
    <div class="mb-8">
        <form action="{{ route('shop.index') }}" method="GET" class="group">
            <div class="relative">
                <input type="text" name="search" 
                    placeholder="{{ __('Search sneakers...') }}" 
                    value="{{ request('search') }}"
                    class="w-full bg-bg-light border-2 border-transparent rounded-[50px] py-3 pl-11 pr-4 text-[0.85rem] transition-all duration-300 focus:bg-input-bg focus:border-brand-primary focus:outline-none focus:ring-0 focus:ring-brand-primary/10">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-[#9ca3af] transition-colors duration-300 group-focus-within:text-brand-primary"></i>
            </div>
        </form>
    </div>
    {{-- Variables for styling --}}
    @php
        $sectionTitleClass = "text-[0.85rem] font-extrabold uppercase tracking-wider text-dark mb-4 border-b border-[#f7fafc] pb-2";
        $linkClass = "no-underline text-[0.95rem] transition-all duration-200 block hover:text-brand-primary";
        $activeLinkClass = "text-brand-primary font-bold before:content-['•_']";
    @endphp

    {{-- Gender Filter --}}
    <div class="mb-8">
        <h3 class="{{ $sectionTitleClass }}">{{ __('Gender')}}</h3>
        <ul class="list-none p-0 space-y-2">
            @foreach($genders->sortBy('id') as $gender)
                @php
                    $active = request('gender') == $gender->name;
                    $url = $active 
                        ? route('shop.index', request()->except('gender')) 
                        : route('shop.index', array_merge(request()->query(), ['gender' => $gender->name]));
                @endphp
                <li>
                    <a href="{{ $url }}" class="{{ $linkClass }} {{ $active ? $activeLinkClass : '' }}">                   
                        {{ __($gender->name) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Brand Filter --}}
    <div class="mb-8">
        <h3 class="{{ $sectionTitleClass }}">{{ __('Brands')}}</h3>
        <ul class="list-none p-0 space-y-2">
            <li>
                <a href="{{ route('shop.index') }}" class="{{ $linkClass }} {{ !request('brand') ? $activeLinkClass : '' }}">
                    {{ __('All Brands')}}
                </a>
            </li>
            @foreach($brands->sortBy('name') as $brand)
                <li>
                    <a href="{{ route('shop.index', array_merge(request()->query(), ['brand' => $brand->name])) }}" 
                       class="{{ $linkClass }} {{ request('brand') == $brand->name ? $activeLinkClass : '' }}">
                        {{ $brand->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Usage Filter --}}
    <div class="mb-8">
        <h3 class="{{ $sectionTitleClass }}">{{ __('Usage') }}</h3>
        <ul class="list-none p-0 space-y-2">
            @foreach($usages->sortBy('name') as $usage)
                @php
                    $isActive = request('usage') == $usage->name;
                    $url = $isActive 
                        ? route('shop.index', request()->except('usage')) 
                        : route('shop.index', array_merge(request()->query(), ['usage' => $usage->name]));
                @endphp
                <li>
                    <a href="{{ $url }}" class="{{ $linkClass }} {{ $isActive ? $activeLinkClass : '' }}">
                        {{ __($usage->name) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Price Filter --}}
    <div class="mb-3">
        <h3 class="{{ $sectionTitleClass }}">{{ __('Price')}}</h3>
        <form action="{{ route('shop.index') }}" method="GET">
            @foreach(request()->except(['min_price', 'max_price']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <div class="flex items-center gap-2 mb-3">
                <input type="number" name="min_price" placeholder="Mín" value="{{ request('min_price') }}"
                    class="w-full bg-bg-light border-2 border-transparent p-2 rounded text-[0.85rem] focus:bg-input-bg focus:border-brand-primary focus:outline-none focus:ring-0 focus:ring-brand-primary/10">
                <span class="text-muted">-</span>
                <input type="number" name="max_price" placeholder="Máx" value="{{ request('max_price') }}"
                    class="w-full bg-bg-light border-2 border-transparent p-2 rounded text-[0.85rem] focus:bg-input-bg focus:border-brand-primary focus:outline-none focus:ring-0 focus:ring-brand-primary/10">
            </div>
            {{-- Filter Button --}}
            <button type="submit" class="w-full bg-brand-secondary-soft text-white py-2 rounded-md text-[0.85rem] font-semibold hover:bg-brand-secondary transition-colors">
                {{ __('Filter')}}
            </button>
        </form>
    </div> 

    {{-- Clear Filters Link --}}
    @if(request()->anyFilled(['brand', 'search', 'min_price', 'max_price', 'gender', 'usage']))
        <div class="p-3">
            <a href="{{ route('shop.index') }}" class="block text-center text-[0.75rem] text-brand-primary-soft uppercase font-bold no-underline hover:underline">
                {{ __('Clear Filter') }}
            </a>
        </div>
    @endif
</aside>