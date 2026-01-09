<x-app-layout>
    <div class="flex min-h-screen bg-bg-light">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main wrapper --}}
        <main class="flex-1 p-10">

            {{-- Header --}}
            <header class="flex flex-col items-center text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight uppercase font-font-title text-main-text">
                    {{ __('Edit Product') }}
                </h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                    {{ __('Edit the product details below.') }}
                </p>
            </header>

            {{-- Form container --}}
            <section class="mx-auto bg-white dark:bg-slate-900 rounded-2xl p-8 shadow flex flex-col gap-6">
                <div class="form-card"> 
                    <p class="text-dark">
                        {{ __('Editing: ') }} 
                        <span class="text-brand-primary font-bold">{{ $product->name }}</span>
                    </p>

                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}:</label>
                            <input type="text" name="name" id="name" placeholder="{{ __('Sneaker name') }}" 
                                   value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="form-row-flex">
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}:</label>
                                <textarea name="description" id="description" placeholder="{{ __('Detailed description') }}">{{ old('description', $product->description) }}</textarea>
                            </div>

                            <div class="form-group form-group-image">
                                <label class="label-primary">{{ __('Product Image') }}</label>
    
                                <div class="image-editor-wrapper">
                                    <input type="file" name="img" id="img" class="input-hidden" accept="image/*" onchange="previewImage(event)">
        
                                    <label for="img" class="image-click-area" title="{{ __('Click to change the image')}}">
                                        @if ($product->img)
                                            <img id="main-preview" src="{{ asset('images/products/' . $product->img) }}" alt="{{ $product->name }}" class="img">
                                        @else
                                            <div id="text-placeholder" class="text-placeholder">
                                                <span>+ {{ __('Upload Image') }}</span>
                                            </div>
                                        @endif
                                        <div class="overlay">
                                            <span>{{ __('Change Image') }}</span>
                                        </div>
                                    </label>
                                </div>
                                <small class="text-help">{{ __('Click on the image to replace it.') }}</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="price">{{ __('Price')}}:</label>
                                <input type="number" name="price" id="price" placeholder="99.99" step="0.01" 
                                       value="{{ old('price', $product->price) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="stock">Stock:</label>
                                <input type="number" name="stock" id="stock" placeholder="{{ __('Quantity') }}" 
                                       value="{{ old('stock', $product->stock) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="categories">{{ __('Categories') }}:</label>
                            <select id="categories" name="categories[]" multiple>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ $product->categories->contains($category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-help">{{ __('Hold down Ctrl (or Cmd) to select multiple.') }}</small>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('admin.products.index') }}" class="btn-back">{{ __('Back to list')}}</a>
                            <button type="submit" class="btn">{{ __('Update Product') }}</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoriesSelect = document.getElementById('categories');
            if (categoriesSelect) {
                new Choices(categoriesSelect, {
                    removeItemButton: true, 
                    searchEnabled: true,
                    shouldSort: false,
                    placeholderValue: '{{ __('Select categories') }}'
                });
            }
        });
    </script>
</x-app-layout>
