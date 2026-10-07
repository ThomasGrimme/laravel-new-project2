<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 transition hover:text-gray-900">
            <span aria-hidden="true">&larr;</span> {{ __('back_to_shop.text') }}
        </a>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                <div class="overflow-hidden rounded-lg bg-gray-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-64 w-full object-cover md:h-full md:min-h-[420px]">
                    @else
                        <div class="flex h-64 w-full items-center justify-center md:min-h-[420px]">
                            <span class="font-serif text-6xl text-gray-900">&euro;{{ number_format($product->price, 2) }}</span>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col">
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <span class="font-medium text-gray-700">{{ $product->category->name }}</span>
                        <span aria-hidden="true">&middot;</span>
                        @if($product->inStock())
                            <span class="text-green-700">{{ __('count_in_stock.text', ['count' => $product->stock]) }}</span>
                        @else
                            <span class="text-red-600">{{ __('out_of_stock.text') }}</span>
                        @endif
                    </div>

                    <h1 class="mt-3 text-2xl font-semibold leading-tight text-gray-900">{{ $product->name }}</h1>

                    <p class="mt-2 font-serif text-3xl text-gray-900">
                        &euro;{{ number_format($product->price, 2) }}
                    </p>

                    @if($product->description)
                        <div class="mt-5 break-words text-sm leading-[1.8] text-gray-700">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    @endif

                    @if($product->post)
                        <div class="mt-6 rounded-lg bg-gray-50 p-4">
                            <p class="text-xs text-gray-500">{{ __('related_blog_post.text') }}</p>
                            <a href="{{ route('posts.show', $product->post) }}" class="mt-0.5 inline-block text-sm font-medium text-gray-900 underline decoration-gray-300 underline-offset-4 transition hover:decoration-gray-900">
                                {{ $product->post->title }}
                            </a>
                        </div>
                    @endif

                    <p class="mt-6 text-xs text-gray-500">
                        {{ __('listed_by_name.text', ['name' => $product->user->name]) }}
                    </p>

                    <div class="mt-auto pt-8">
                        @auth
                            @if($product->inStock())
                                <form action="{{ route('cart.add') }}" method="POST" class="flex items-center gap-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="flex items-center rounded-md border border-gray-300">
                                        <button type="button" onclick="this.nextElementSibling.stepDown()" aria-label="{{ __('decrease_quantity.text') }}" class="px-3 py-2 text-gray-500 transition hover:text-gray-900">&minus;</button>
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" aria-label="{{ __('quantity.text') }}" class="w-14 border-0 p-0 text-center focus:ring-0">
                                        <button type="button" onclick="this.previousElementSibling.stepUp()" aria-label="{{ __('increase_quantity.text') }}" class="px-3 py-2 text-gray-500 transition hover:text-gray-900">+</button>
                                    </div>
                                    <x-button size="lg">{{ __('add_to_cart.text') }}</x-button>
                                </form>
                            @else
                                <p class="text-sm font-medium text-red-600">{{ __('this_product_is_currently_out_of_stock.text') }}</p>
                            @endif
                        @else
                            <p class="text-sm text-gray-500">
                                <a href="{{ route('login') }}" class="font-medium text-gray-900 underline decoration-gray-300 underline-offset-4 transition hover:decoration-gray-900">{{ __('log_in.text') }}</a>
                                {{ __('to_add_to_cart.text') }}
                            </p>
                        @endauth

                        @auth
                            @if($product->user_id === auth()->id() || auth()->user()->isAdmin())
                                <div class="mt-6 flex items-center gap-2 border-t border-gray-200 pt-6">
                                    <x-button variant="secondary" size="sm" href="{{ route('products.edit', $product) }}">{{ __('edit.text') }}</x-button>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('{{ __('delete_this_product.text') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <x-button variant="danger-ghost" size="sm">{{ __('delete.text') }}</x-button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
