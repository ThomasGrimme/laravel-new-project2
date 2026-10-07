<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('create_post.text') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">{{ __('title.text') }}</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm w-full">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">{{ __('content.text') }}</label>
                            <textarea name="content" id="content" rows="8" required
                                class="border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm w-full">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('tags.text') }}</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach($tags as $tag)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                                        <span class="ms-2 text-sm text-gray-700">{{ $tag->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-2">
                            <x-button>{{ __('create_post.text') }}</x-button>
                            <x-button variant="secondary" href="{{ route('posts.index') }}">{{ __('cancel.text') }}</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
