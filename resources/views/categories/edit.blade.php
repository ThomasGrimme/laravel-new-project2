<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('edit_category.text') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('name.text') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                                class="border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm w-full">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">{{ __('description_optional.text') }}</label>
                            <textarea name="description" id="description" rows="3"
                                class="border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm w-full">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-2">
                            <x-button>{{ __('update_category.text') }}</x-button>
                            <x-button variant="secondary" href="{{ route('admin.categories.index') }}">{{ __('cancel.text') }}</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
