<?php

use App\Models\Categorie;
use App\Models\Post;
use App\Models\User;

function postOwnedBy(User $user): Post
{
    return Post::factory()->create(['user_id' => $user->id]);
}

test('guests cannot reach the post management pages', function () {
    $this->get(route('posts.create'))->assertRedirect(route('login'));
    $this->get(route('posts.myPosts'))->assertRedirect(route('login'));
    $this->post(route('posts.store'), [])->assertRedirect(route('login'));
});

test('a user can open the create form', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('posts.create'))
        ->assertOk();
});

test('a user can create a post', function () {
    $user = User::factory()->create();
    $category = Categorie::factory()->create();

    $this->actingAs($user)
        ->post(route('posts.store'), [
            'title' => 'My first post',
            'content' => 'Some content',
            'category_id' => $category->id,
        ])
        ->assertSessionHasNoErrors();

    $post = Post::firstWhere('title', 'My first post');

    expect($post)->not->toBeNull()
        ->and($post->user_id)->toBe($user->id);
});

test('my posts only lists the posts owned by the user', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    $mine = postOwnedBy($user);
    $theirs = postOwnedBy($other);

    $this->actingAs($user)
        ->get(route('posts.myPosts'))
        ->assertOk()
        ->assertSee($mine->title)
        ->assertDontSee($theirs->title);
});

test('my posts shows a single create post call to action', function () {
    $user = User::factory()->create();
    $createUrl = route('posts.create');

    $withoutPosts = $this->actingAs($user)->get(route('posts.myPosts'))->assertOk();

    expect(substr_count($withoutPosts->getContent(), $createUrl))->toBe(1);

    postOwnedBy($user);

    $withPosts = $this->actingAs($user)->get(route('posts.myPosts'))->assertOk();

    expect(substr_count($withPosts->getContent(), $createUrl))->toBe(1);
});

test('a user can edit their own post', function () {
    $user = User::factory()->create();
    $post = postOwnedBy($user);

    $this->actingAs($user)
        ->get(route('posts.edit', $post))
        ->assertOk();

    $this->actingAs($user)
        ->put(route('posts.update', $post), [
            'title' => 'Updated title',
            'content' => 'Updated content',
            'category_id' => $post->category_id,
        ])
        ->assertSessionHasNoErrors();

    expect($post->refresh()->title)->toBe('Updated title');
});

test('a user cannot edit another user post', function () {
    $post = postOwnedBy(User::factory()->create());

    $this->actingAs(User::factory()->create())
        ->get(route('posts.edit', $post))
        ->assertForbidden();

    $this->actingAs(User::factory()->create())
        ->put(route('posts.update', $post), [
            'title' => 'Hijacked',
            'content' => 'Hijacked',
            'category_id' => $post->category_id,
        ])
        ->assertForbidden();

    expect($post->refresh()->title)->not->toBe('Hijacked');
});

test('a user can delete their own post', function () {
    $user = User::factory()->create();
    $post = postOwnedBy($user);

    $this->actingAs($user)
        ->delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.myPosts'));

    expect(Post::find($post->id))->toBeNull();
});

test('a user cannot delete another user post', function () {
    $post = postOwnedBy(User::factory()->create());

    $this->actingAs(User::factory()->create())
        ->delete(route('posts.destroy', $post))
        ->assertForbidden();

    expect(Post::find($post->id))->not->toBeNull();
});

test('an admin can edit and delete any post', function () {
    $admin = User::factory()->admin()->create();
    $post = postOwnedBy(User::factory()->create());

    $this->actingAs($admin)
        ->get(route('posts.edit', $post))
        ->assertOk();

    $this->actingAs($admin)
        ->put(route('posts.update', $post), [
            'title' => 'Moderated title',
            'content' => 'Moderated content',
            'category_id' => $post->category_id,
        ])
        ->assertSessionHasNoErrors();

    expect($post->refresh()->title)->toBe('Moderated title');

    $this->actingAs($admin)
        ->delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.myPosts'));

    expect(Post::find($post->id))->toBeNull();
});

test('the blog index only shows management buttons the visitor may use', function () {
    $post = postOwnedBy(User::factory()->create());
    $deleteAction = 'action="'.route('posts.destroy', $post).'"';

    $this->actingAs(User::factory()->create())
        ->get(route('posts.index'))
        ->assertOk()
        ->assertDontSee(route('posts.edit', $post), false)
        ->assertDontSee($deleteAction, false);

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('posts.index'))
        ->assertOk()
        ->assertSee(route('posts.edit', $post), false)
        ->assertSee($deleteAction, false);
});

test('the blog show page only shows management buttons the visitor may use', function () {
    $post = postOwnedBy(User::factory()->create());
    $deleteAction = 'action="'.route('posts.destroy', $post).'"';

    $this->actingAs(User::factory()->create())
        ->get(route('posts.show', $post))
        ->assertOk()
        ->assertDontSee(route('posts.edit', $post), false)
        ->assertDontSee($deleteAction, false);

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('posts.show', $post))
        ->assertOk()
        ->assertSee(route('posts.edit', $post), false)
        ->assertSee($deleteAction, false);
});

test('the owner sees the management buttons on their own post', function () {
    $post = postOwnedBy(User::factory()->create());

    $this->actingAs($post->user)
        ->get(route('posts.show', $post))
        ->assertOk()
        ->assertSee(route('posts.edit', $post), false)
        ->assertSee('action="'.route('posts.destroy', $post).'"', false);
});
