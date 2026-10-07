<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'content' => fake()->paragraphs(3, true),
            'image' => null,
            'category_id' => Categorie::factory(),
            'user_id' => User::factory(),
        ];
    }
}
