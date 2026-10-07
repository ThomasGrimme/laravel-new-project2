<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('sell_a_product.text') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('product_name.text') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm w-full">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">{{ __('description.text') }}</label>
                            <textarea name="description" id="description" rows="4"
                                class="border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm w-full">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1"{{ __('price.text') }} (&euro;)/label>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                                    class="border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm w-full">
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">{{ __('stock.text') }}</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', 1) }}" min="0" required
                                    class="border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm w-full">
                                @error('stock')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">{{ __('image_optional.text') }}</label>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm w-full">
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('category.text') }}</label>
                            <select name="category_id" id="category_id" required
                                class="border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm w-full">
                                <option value="">{{ __('select_a_category.text') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if($posts->count())
                            <div class="mb-6">
                                <label for="post_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('link_to_blog_post_optional.text') }}</label>
                                <select name="post_id" id="post_id"
                                    class="border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm w-full">
                                    <option value="">{{ __('no_linked_post.text') }}</option>
                                    @foreach($posts as $post)
                                        <option value="{{ $post->id }}" {{ old('post_id') == $post->id ? 'selected' : '' }}>
                                            {{ $post->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('post_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="flex gap-2">
                            <x-button>{{ __('list_product.text') }}</x-button>
                            <x-button variant="secondary" href="{{ route('shop.index') }}">{{ __('cancel.text') }}</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
