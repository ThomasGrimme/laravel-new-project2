<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'user_name' => 'required|string|max:255',
        ]);

        $validated['post_id'] = $post->id;

        Comment::create($validated);

        return redirect()->route('posts.show', $post)->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $post = $comment->post;
        $comment->delete();

        return redirect()->route('posts.show', $post)->with('success', 'Comment deleted successfully.');
    }
}
