@props([
    'post',
    'show' => false,
])

<article {{ $attributes->merge(['class' => 'group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white transition hover:border-gray-300 hover:shadow-sm']) }}>
    @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="h-48 w-full object-cover">
    @else
        <div class="flex h-48 w-full items-center justify-center bg-gray-100">
            <span aria-hidden="true" class="select-none font-serif text-6xl text-gray-400">{{ strtoupper(substr($post->title, 0, 1)) }}</span>
        </div>
    @endif

    <div class="flex flex-1 flex-col gap-3 p-5">
        <div class="flex items-center gap-2 text-xs text-gray-500">
            <span class="font-medium text-gray-700">{{ $post->category->name }}</span>
            <span aria-hidden="true">&middot;</span>
            <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->diffForHumans() }}</time>
        </div>

        <h2 class="text-base font-semibold leading-snug text-gray-900">
            <a href="{{ route('posts.show', $post) }}" class="after:absolute after:inset-0 group-hover:text-gray-600">
                {{ $post->title }}
            </a>
        </h2>

        <p class="line-clamp-3 text-sm leading-relaxed text-gray-500">{{ Str::limit($post->content, 150) }}</p>

        @if($post->tags->isNotEmpty())
            <ul class="flex flex-wrap gap-1.5">
                @foreach($post->tags as $tag)
                    <li class="rounded bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $tag->name }}</li>
                @endforeach
            </ul>
        @endif

        <p class="mt-auto pt-1 text-xs text-gray-500">
            {{ __('by_name.text', ['name' => $post->user->name]) }}
        </p>
    </div>

    @if($show || auth()->user()?->can('update', $post))
        <div class="relative z-10 flex items-center gap-1 border-t border-gray-100 px-5 py-3">
            @if($show)
                <x-button variant="ghost" size="sm" href="{{ route('posts.show', $post) }}">{{ __('view.text') }}</x-button>
            @endif
            @can('update', $post)
                <x-button variant="ghost" size="sm" href="{{ route('posts.edit', $post) }}">{{ __('edit.text') }}</x-button>
            @endcan
            @can('delete', $post)
                <form method="POST" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('{{ __('delete_this_post.text') }}')">
                    @csrf
                    @method('DELETE')
                    <x-button variant="danger-ghost" size="sm">{{ __('delete.text') }}</x-button>
                </form>
            @endcan
        </div>
    @endif
</article>
