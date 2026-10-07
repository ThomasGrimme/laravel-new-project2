<?php

use App\Models\Order;
use App\Models\User;

function orderFor(User $user, array $attributes = []): Order
{
    return Order::create(array_merge([
        'user_id' => $user->id,
        'total' => 49.95,
        'status' => 'pending',
    ], $attributes));
}

test('guests are redirected away from the admin order list', function () {
    $this->get(route('admin.orders.index'))->assertRedirect(route('login'));
});

test('a regular user cannot reach the admin order list', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.orders.index'))
        ->assertForbidden();
});

test('an admin sees the orders placed by every user', function () {
    $admin = User::factory()->admin()->create();
    $first = User::factory()->create(['name' => 'Ada Lovelace']);
    $second = User::factory()->create(['name' => 'Grace Hopper']);

    orderFor($first, ['total' => 10.00]);
    orderFor($second, ['total' => 20.00]);

    $this->actingAs($admin)
        ->get(route('admin.orders.index'))
        ->assertOk()
        ->assertSee('Ada Lovelace')
        ->assertSee('Grace Hopper');
});

test('the admin order list does not expose order details of other users to a regular user', function () {
    $order = orderFor(User::factory()->create());

    $this->actingAs(User::factory()->create())
        ->get(route('orders.show', $order))
        ->assertForbidden();
});

test('an admin can open an order placed by another user', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create(['name' => 'Alan Turing']);
    $order = orderFor($customer);

    $response = $this->actingAs($admin)
        ->get(route('orders.show', $order))
        ->assertOk()
        ->assertSee('Alan Turing');

    expect($response->viewData('backRoute'))->toBe('admin.orders.index');
});

test('an admin keeps their own orders on the my orders page', function () {
    $admin = User::factory()->admin()->create();
    $order = orderFor($admin);

    $response = $this->actingAs($admin)
        ->get(route('orders.show', $order))
        ->assertOk();

    expect($response->viewData('backRoute'))->toBe('orders.index');
});

test('a user is sent back to their own order list', function () {
    $user = User::factory()->create();
    $order = orderFor($user);

    $response = $this->actingAs($user)
        ->get(route('orders.show', $order))
        ->assertOk();

    expect($response->viewData('backRoute'))->toBe('orders.index');
});

test('a user still only sees their own orders', function () {
    $user = User::factory()->create();
    $mine = orderFor($user);
    $theirs = orderFor(User::factory()->create());

    $this->actingAs($user)
        ->get(route('orders.index'))
        ->assertOk()
        ->assertSee('#'.$mine->id)
        ->assertDontSee('#'.$theirs->id);
});

test('the admin order navigation link is only rendered for admins', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->get(route('orders.index'))
        ->assertOk()
        ->assertSee(route('admin.orders.index'), false);

    $this->actingAs(User::factory()->create())
        ->get(route('orders.index'))
        ->assertOk()
        ->assertDontSee(route('admin.orders.index'), false);
});
