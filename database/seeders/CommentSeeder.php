<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            ['post_title' => 'iPhone 16 Pro Review', 'user_name' => 'Jan', 'content' => 'Great review! The camera improvements are really impressive this year.'],
            ['post_title' => 'iPhone 16 Pro Review', 'user_name' => 'Sophie', 'content' => 'Is the battery life really that much better? My 15 Pro barely lasts a day.'],
            ['post_title' => 'Top 5 Budget Laptops for Students', 'user_name' => 'Mark', 'content' => 'The Lenovo IdeaPad 3 is exactly what I need for university. Thanks!'],
            ['post_title' => 'Nike Air Max 90: Still Worth It?', 'user_name' => 'Lisa', 'content' => 'I have had mine for 3 years and they still look great. Classic shoe.'],
            ['post_title' => 'Best Gaming Headsets Under €100', 'user_name' => 'Tom', 'content' => 'The HyperX Cloud II is super comfortable for long gaming sessions.'],
            ['post_title' => 'Review: IKEA KALLAX Shelf Unit', 'user_name' => 'Emma', 'content' => 'Using this as a room divider and it works perfectly. Highly recommend!'],
        ];

        foreach ($comments as $commentData) {
            $post = Post::where('title', $commentData['post_title'])->first();
            if ($post) {
                Comment::create([
                    'content' => $commentData['content'],
                    'user_name' => $commentData['user_name'],
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}
