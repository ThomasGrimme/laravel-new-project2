<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('shop.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Back</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:flex">
                    @if($product->image)
                        <div class="md:w-1/2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-64 md:h-full object-cover">
                        </div>
                    @else
                        <div class="md:w-1/2 bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center h-64 md:h-auto md:min-h-[400px]">
                            <span class="text-white text-6xl">${{ number_format($product->price, 2) }}</span>
                        </div>
                    @endif
                    <div class="md:w-1/2 p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $product->category->name }}
                            </span>
                            @if($product->inStock())
                                <span class="text-sm text-green-600">{{ $product->stock }} in stock</span>
                            @else
                                <span class="text-sm text-red-600">Out of stock</span>
                            @endif
                        </div>

                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                        <p class="text-3xl font-bold text-indigo-600 mb-4">&euro;{{ number_format($product->price, 2) }}</p>

                        @if($product->description)
                            <div class="text-gray-600 mb-6">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        @endif

                        @if($product->post)
                            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Related blog post:</p>
                                <a href="{{ route('posts.show', $product->post) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                    {{ $product->post->title }} &rarr;
                                </a>
                            </div>
                        @endif

                        <div class="text-sm text-gray-500 mb-6">
                            Listed by {{ $product->user->name }}
                        </div>

                        @auth
                            @if($product->inStock())
                                <form action="{{ route('cart.add') }}" method="POST" class="flex items-center gap-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="flex items-center border border-gray-300 rounded-md">
                                        <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-3 py-2 text-gray-600 hover:text-gray-900">-</button>
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 text-center border-0 focus:ring-0">
                                        <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-3 py-2 text-gray-600 hover:text-gray-900">+</button>
                                    </div>
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <p class="text-red-600 font-medium">This product is currently out of stock.</p>
                            @endif
                        @else
                            <p class="text-gray-500">
                                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-900">Log in</a> to add to cart.
                            </p>
                        @endauth

                        @auth
                            @if($product->user_id === auth()->id() || auth()->user()->isAdmin())
                                <div class="mt-6 pt-6 border-t border-gray-200 flex gap-2">
                                    <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Delete
                                        </button>
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
