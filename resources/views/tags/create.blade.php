<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('create_tag.text') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.tags.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('name.text') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm w-full">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-2">
                            <x-button>{{ __('create_tag.text') }}</x-button>
                            <x-button variant="secondary" href="{{ route('admin.tags.index') }}">{{ __('cancel.text') }}</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
