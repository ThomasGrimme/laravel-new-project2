<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 transition hover:text-gray-900">
            <span aria-hidden="true">&larr;</span> {{ __('back_to_blog.text') }}
        </a>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <article>
                <header class="mb-8">
                    <h1 class="font-serif text-3xl font-semibold leading-tight tracking-tight text-gray-900 sm:text-4xl">
                        {{ $post->title }}
                    </h1>

                    <div class="mt-4 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-gray-500">
                        <span class="font-medium text-gray-700">{{ $post->category->name }}</span>
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ __('by_name.text', ['name' => $post->user->name]) }}</span>
                        <span aria-hidden="true">&middot;</span>
                        <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('M j, Y') }}</time>
                    </div>

                    @if($post->tags->isNotEmpty())
                        <ul class="mt-4 flex flex-wrap gap-1.5">
                            @foreach($post->tags as $tag)
                                <li class="rounded bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $tag->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </header>

                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="mb-10 w-full rounded-lg object-cover">
                @endif

                <div class="break-words text-base leading-[1.8] text-gray-800">
                    {!! nl2br(e($post->content)) !!}
                </div>

                @can('update', $post)
                    <div class="mt-10 flex items-center gap-2 border-t border-gray-200 pt-6">
                        <x-button variant="secondary" size="sm" href="{{ route('posts.edit', $post) }}">{{ __('edit.text') }}</x-button>
                        @can('delete', $post)
                            <form method="POST" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('{{ __('delete_this_post.text') }}')">
                                @csrf
                                @method('DELETE')
                                <x-button variant="danger-ghost" size="sm">{{ __('delete.text') }}</x-button>
                            </form>
                        @endcan
                    </div>
                @endcan
            </article>

            <!-- Comments -->
            <section class="mt-16 border-t border-gray-200 pt-10">
                <h2 class="text-sm font-semibold text-gray-900">
                    {{ __('comments_count.text', ['count' => $post->comments->count()]) }}
                </h2>

                @forelse($post->comments as $comment)
                    <div class="border-b border-gray-100 py-5 last:border-0">
                        <div class="flex items-baseline gap-2">
                            <span class="text-sm font-medium text-gray-900">{{ $comment->user_name }}</span>
                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mt-1.5 text-sm leading-relaxed text-gray-700">{{ $comment->content }}</p>
                        @auth
                            @if(auth()->user()->isAdmin() || auth()->user()->name === $comment->user_name)
                                <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="mt-2" onsubmit="return confirm('{{ __('delete_this_comment.text') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-gray-400 transition hover:text-red-600">
                                        {{ __('delete.text') }}
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                @empty
                    <p class="py-6 text-sm text-gray-500">{{ __('no_comments_yet.text') }}</p>
                @endforelse

                <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-8 space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="user_name" :value="__('name.text')" />
                        <x-text-input id="user_name" name="user_name" value="{{ old('user_name', auth()->check() ? auth()->user()->name : '') }}" class="mt-1.5 w-full" required />
                        <x-input-error :messages="$errors->get('user_name')" class="mt-1.5" />
                    </div>
                    <div>
                        <x-input-label for="content" :value="__('comment.text')" />
                        <textarea id="content" name="content" rows="3" required
                            class="mt-1.5 w-full rounded-md border-gray-300 shadow-sm transition focus:border-gray-900 focus:ring-gray-900">{{ old('content') }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-1.5" />
                    </div>
                    <x-button>{{ __('post_comment.text') }}</x-button>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
