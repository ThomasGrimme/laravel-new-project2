<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">Welcome back, <strong>{{ auth()->user()->name }}</strong>! You are logged in as <strong>{{ ucfirst(auth()->user()->role) }}</strong>.</p>

                    <div class="mt-6">
                        <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            View Blog
                        </a>
                    </div>

                    @if(auth()->user()->isAdmin())
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Admin Panel</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <a href="{{ route('admin.posts.create') }}" class="block p-4 border border-gray-200 rounded-lg hover:border-indigo-500 hover:shadow-md transition">
                                    <h4 class="font-medium text-gray-900">New Post</h4>
                                    <p class="text-sm text-gray-500 mt-1">Create a new blog post</p>
                                </a>
                                <a href="{{ route('admin.categories.index') }}" class="block p-4 border border-gray-200 rounded-lg hover:border-indigo-500 hover:shadow-md transition">
                                    <h4 class="font-medium text-gray-900">Categories</h4>
                                    <p class="text-sm text-gray-500 mt-1">Manage post categories</p>
                                </a>
                                <a href="{{ route('admin.tags.index') }}" class="block p-4 border border-gray-200 rounded-lg hover:border-indigo-500 hover:shadow-md transition">
                                    <h4 class="font-medium text-gray-900">Tags</h4>
                                    <p class="text-sm text-gray-500 mt-1">Manage post tags</p>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
