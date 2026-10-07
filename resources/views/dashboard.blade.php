<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-900">
            {{ __('dashboard.text') }}
        </h1>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <p class="text-sm text-gray-500">
                {{ __('welcome_back_name.text', [
                    'name' => auth()->user()->name,
                ]) }}
            </p>
        </div>
    </div>
</x-app-layout>
