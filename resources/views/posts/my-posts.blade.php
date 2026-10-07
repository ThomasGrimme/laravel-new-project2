<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-900">
            {{ __('my_posts.text') }}
        </h1>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            @if($posts->count())
                <div class="mb-8 flex justify-center">
                    <x-button href="{{ route('posts.create') }}">{{ __('new_post.text') }}</x-button>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($posts as $post)
                        <x-post-card :post="$post" show />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="rounded-lg border border-dashed border-gray-300 py-20 text-center">
                    <p class="text-sm text-gray-500">{{ __("no_written_posts_yet.text") }}</p>
                    <x-button href="{{ route('posts.create') }}" class="mt-5">
                        {{ __('write_your_first_post.text') }}
                    </x-button>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
