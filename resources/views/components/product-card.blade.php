@props([
    'product',
    'manage' => false,
])

<article {{ $attributes->merge(['class' => 'group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white transition hover:border-gray-300 hover:shadow-sm']) }}>
    @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-48 w-full object-cover">
    @else
        <div class="flex h-48 w-full items-center justify-center bg-gray-100">
            <span class="font-serif text-4xl text-gray-900">&euro;{{ number_format($product->price, 2) }}</span>
        </div>
    @endif

    <div class="flex flex-1 flex-col gap-3 p-5">
        <div class="flex items-center gap-2 text-xs text-gray-500">
            <span class="font-medium text-gray-700">{{ $product->category->name }}</span>
            <span aria-hidden="true">&middot;</span>
            @if($product->inStock())
                <span class="text-green-700">{{ __('count_in_stock.text', ['count' => $product->stock]) }}</span>
            @else
                <span class="text-red-600">{{ __('out_of_stock.text') }}</span>
            @endif
        </div>

        <h2 class="text-base font-semibold leading-snug text-gray-900">
            <a href="{{ route('shop.show', $product) }}" class="after:absolute after:inset-0 group-hover:text-gray-600">
                {{ $product->name }}
            </a>
        </h2>

        @if($product->description)
            <p class="line-clamp-2 text-sm leading-relaxed text-gray-500">{{ Str::limit($product->description, 100) }}</p>
        @endif

        <p class="mt-auto pt-1 text-lg font-semibold text-gray-900">
            &euro;{{ number_format($product->price, 2) }}
        </p>
    </div>

    @if($manage)
        <div class="relative z-10 flex items-center gap-1 border-t border-gray-100 px-5 py-3">
            <x-button variant="ghost" size="sm" href="{{ route('products.edit', $product) }}">{{ __('edit.text') }}</x-button>
            <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('{{ __('delete_this_product.text') }}')">
                @csrf
                @method('DELETE')
                <x-button variant="danger-ghost" size="sm">{{ __('delete.text') }}</x-button>
            </form>
        </div>
    @endif
</article>
