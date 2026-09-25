<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('posts.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Back</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $post->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
                @endif
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ $post->category->name }}
                        </span>
                        @foreach($post->tags as $tag)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                        <span>By {{ $post->user->name }}</span>
                        <span>&middot;</span>
                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="prose max-w-none">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <div class="mt-6 pt-6 border-t border-gray-200 flex gap-2">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Edit
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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

            <!-- Comments -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Comments ({{ $post->comments->count() }})</h3>

                    @foreach($post->comments as $comment)
                        <div class="border-b border-gray-100 last:border-0 py-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-medium text-gray-900">{{ $comment->user_name }}</span>
                                <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-600">{{ $comment->content }}</p>
                            @auth
                                @if(auth()->user()->isAdmin() || auth()->user()->name === $comment->user_name)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2" onsubmit="return confirm('Delete this comment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    @endforeach

                    <!-- Add Comment Form -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-3">Leave a comment</h4>
                        <form action="{{ route('comments.store', $post) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="user_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input type="text" name="user_name" id="user_name" value="{{ old('user_name', auth()->check() ? auth()->user()->name : '') }}" required
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                @error('user_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
                                <textarea name="content" id="content" rows="3" required
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Post Comment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
