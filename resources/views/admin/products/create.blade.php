<x-app-layout>
    <div class="flex min-h-screen bg-bg-light">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main wrapper --}}
        <main class="flex-1 p-10">

            {{-- Header --}}
            <header class="flex flex-col items-center text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight uppercase font-font-title text-main-text">
                    {{ __('Create Product') }}
                </h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                    {{ __('Fill in the details to add a new product.') }}
                </p>
            </header>

            {{-- Form container --}}
            <section class="mx-auto bg-white dark:bg-slate-900 rounded-2xl p-8 shadow flex flex-col gap-6">
                <div class="form-card"> 
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-grid">
                            <div class="form-column-left">
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}:</label>
                                    <input type="text" name="name" id="name" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">{{ __('Description') }}:</label>
                                    <textarea name="description" id="description"></textarea>
                                </div>
                            </div>

                            <div class="form-group form-image">
                                <label>{{ __('Product Image') }}:</label>

                                <div class="image-editor-wrapper left">
                                    <input type="file" name="img" id="img" class="input-hidden" accept="image/*" onchange="previewImage(event)">
            
                                    <label for="img" class="image-click-area" title="Click to upload the image">
                                            <div id="text-placeholder" class="text-placeholder">
                                                <span>+ {{ __('Upload Image') }}</span>
                                            </div>
                                        <div class="overlay">
                                            <span>{{ __('Upload Image') }}</span>
                                        </div>
                                    </label>
                                </div>
                                    <small class="text-help">{{ __('Click on the image to replace it.') }}</small>
                            </div>
                        </div>

                        <div class="form-row"> 
                            <div class="form-group">
                                <label for="price">{{ __('Price')}}:</label>
                                <input type="number" name="price" id="price" placeholder="99.99" step="0.01" value="{{ old('price') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="stock">Stock:</label>
                                <input type="number" name="stock" id="stock" placeholder="{{ __('Quantity') }}" value="{{ old('stock') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="categories">{{ __('Categories') }}:</label>
                            <select id="categories" name="categories[]" multiple>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-actions">
                            <a href="{{ route('admin.products.index') }}" class="btn-back">{{ __('Back to list')}}</a>
                            <button type="submit" class="btn">{{ __('Save Product') }}</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</x-app-layout>