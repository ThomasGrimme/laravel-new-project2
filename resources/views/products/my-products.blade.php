<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-xl font-semibold leading-tight text-gray-900">
                {{ __('my_products.text') }}
            </h1>
            <x-button href="{{ route('products.create') }}">{{ __('add_product.text') }}</x-button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            @if($products->count())
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($products as $product)
                        <x-product-card :product="$product" manage />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="rounded-lg border border-dashed border-gray-300 py-20 text-center">
                    <p class="text-sm text-gray-500">{{ __("no_listed_products_yet.text") }}</p>
                    <x-button href="{{ route('products.create') }}" class="mt-5">
                        {{ __('list_your_first_product.text') }}
                    </x-button>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
