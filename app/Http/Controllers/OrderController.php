<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if (! $cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $order = DB::transaction(function () use ($cart) {
            $total = 0;
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => 0,
                'status' => 'pending',
            ]);

            foreach ($cart->items as $cartItem) {
                $product = $cartItem->product;

                if ($cartItem->quantity > $product->stock) {
                    throw new \Exception("Not enough stock for {$product->name}. Only {$product->stock} left.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price_at_time' => $product->price,
                ]);

                $total += $product->price * $cartItem->quantity;
                $product->decrement('stock', $cartItem->quantity);
            }

            $order->update(['total' => $total]);
            $cart->items()->delete();

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id() && ! auth()->user()->isAdmin()) {
            abort(403);
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
}
