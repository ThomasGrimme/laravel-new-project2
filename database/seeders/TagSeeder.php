<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Budget-friendly',
            'Premium',
            'Bestseller',
            'New arrival',
            'Recommended',
            'Trending',
            'Must-have',
            'Value pick',
        ];

        foreach ($tags as $name) {
            Tag::create(['name' => $name]);
        }
    }
}
