<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('shopping_cart.text') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if($cart->items->count())
                <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('product.text') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('price.text') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('quantity.text') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('subtotal.text') }}</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cart->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-10 w-10 rounded object-cover mr-3">
                                                @else
                                                    <div class="h-10 w-10 rounded bg-gray-100 flex items-center justify-center mr-3">
                                                        <span aria-hidden="true" class="font-serif text-sm text-gray-500">{{ strtoupper(substr($item->product->name, 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <a href="{{ route('shop.show', $item->product) }}" class="text-sm font-medium text-gray-900 hover:text-gray-900">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            &euro;{{ number_format($item->product->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                    class="w-20 border-gray-300 focus:border-gray-900 focus:ring-gray-900 rounded-md shadow-sm text-sm">
                                                <button type="submit" class="text-gray-900 hover:text-black text-sm">{{ __('update.text') }}</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            &euro;{{ number_format($item->subtotal, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <form action="{{ route('cart.remove', $item) }}" method="POST" onsubmit="return confirm('{{ __('remove_this_item.text') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">{{ __('remove.text') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-6 pt-6 border-t border-gray-200 flex items-center justify-between">
                            <div class="text-lg font-semibold text-gray-900">
                                {{ __('total.text') }}: &euro;{{ number_format($cart->total, 2) }}
                            </div>
                            <form action="{{ route('orders.checkout') }}" method="POST">
                                @csrf
                                <x-button size="lg">{{ __('checkout.text') }}</x-button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        <p class="mb-4">{{ __('your_cart_is_empty.text') }}</p>
                        <x-button href="{{ route('shop.index') }}">{{ __('browse_shop.text') }}</x-button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
