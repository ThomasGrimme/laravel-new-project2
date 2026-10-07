<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-xl font-semibold leading-tight text-gray-900">
                {{ __('blog.text') }}
            </h1>
            @auth
                <x-button href="{{ route('posts.create') }}">{{ __('new_post.text') }}</x-button>
            @endauth
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            <!-- Filters -->
            <form method="GET" action="{{ route('posts.index') }}" class="mb-8 flex flex-wrap items-end gap-3">
                <div class="min-w-[11rem] flex-1">
                    <label for="filter-search" class="sr-only">{{ __('search.text') }}</label>
                    <x-text-input id="filter-search" type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('search_posts.text') }}" class="w-full" />
                </div>
                <div class="min-w-[11rem] flex-1">
                    <label for="filter-category" class="sr-only">{{ __('category.text') }}</label>
                    <select id="filter-category" name="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        <option value="">{{ __('all_categories.text') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="min-w-[11rem] flex-1">
                    <label for="filter-tag" class="sr-only">{{ __('tag.text') }}</label>
                    <select id="filter-tag" name="tag" class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        <option value="">{{ __('all_tags.text') }}</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <x-button type="submit">{{ __('filter.text') }}</x-button>
                    <x-button variant="secondary" :href="route('posts.index')">{{ __('clear.text') }}</x-button>
                </div>
            </form>

            <!-- Posts -->
            @if($posts->count())
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="rounded-lg border border-dashed border-gray-300 py-16 text-center">
                    <p class="text-sm text-gray-500">{{ __('no_posts_found.text') }}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
