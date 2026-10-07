<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-xl font-semibold leading-tight text-gray-900">
                {{ __('shop.text') }}
            </h1>
            @auth
                <x-button href="{{ route('products.create') }}">{{ __('sell_a_product.text') }}</x-button>
            @endauth
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            <!-- Filters -->
            <form method="GET" action="{{ route('shop.index') }}" class="mb-8 flex flex-wrap items-end gap-3">
                <div class="min-w-[12rem] flex-1">
                    <label for="filter-search" class="sr-only">{{ __('search.text') }}</label>
                    <x-text-input id="filter-search" type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('search_products.text') }}" class="w-full" />
                </div>
                <div class="min-w-[12rem] flex-1">
                    <label for="filter-category" class="sr-only">{{ __('category.text') }}</label>
                    <select id="filter-category" name="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        <option value="">{{ __('all_categories.text') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <x-button>{{ __('filter.text') }}</x-button>
                    <x-button variant="secondary" :href="route('shop.index')">{{ __('clear.text') }}</x-button>
                </div>
            </form>

            <!-- Products -->
            @if($products->count())
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="rounded-lg border border-dashed border-gray-300 py-16 text-center">
                    <p class="text-sm text-gray-500">{{ __('no_products_found.text') }}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
