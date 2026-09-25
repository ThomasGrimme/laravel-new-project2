<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Categorie;
use App\Models\Post;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        $products = [
            [
                'name' => 'iPhone 16 Pro',
                'description' => 'The latest Apple smartphone with A18 Pro chip, titanium design, and 48MP camera system.',
                'price' => 1199.00,
                'stock' => 25,
                'category_id' => Categorie::where('name', 'Electronics')->first()->id,
                'post_id' => Post::where('title', 'iPhone 16 Pro Review')->first()->id,
            ],
            [
                'name' => 'Lenovo IdeaPad 3',
                'description' => 'Affordable student laptop with Ryzen 5 processor, 8GB RAM, and 256GB SSD.',
                'price' => 449.00,
                'stock' => 40,
                'category_id' => Categorie::where('name', 'Electronics')->first()->id,
                'post_id' => Post::where('title', 'Top 5 Budget Laptops for Students')->first()->id,
            ],
            [
                'name' => 'Nike Air Max 90',
                'description' => 'Classic sneaker with visible Air cushioning and timeless design.',
                'price' => 129.99,
                'stock' => 60,
                'category_id' => Categorie::where('name', 'Clothing')->first()->id,
                'post_id' => Post::where('title', 'Nike Air Max 90: Still Worth It?')->first()->id,
            ],
            [
                'name' => 'HyperX Cloud II',
                'description' => 'Comfortable gaming headset with 7.1 surround sound and noise-cancelling mic.',
                'price' => 89.99,
                'stock' => 35,
                'category_id' => Categorie::where('name', 'Gaming')->first()->id,
                'post_id' => Post::where('title', 'Best Gaming Headsets Under €100')->first()->id,
            ],
            [
                'name' => 'IKEA KALLAX Shelf',
                'description' => 'Versatile shelf unit, perfect as room divider or storage. Multiple sizes available.',
                'price' => 69.99,
                'stock' => 50,
                'category_id' => Categorie::where('name', 'Home & Living')->first()->id,
                'post_id' => Post::where('title', 'Review: IKEA KALLAX Shelf Unit')->first()->id,
            ],
            [
                'name' => 'Barebells Protein Bar (12-pack)',
                'description' => 'High-protein snack bar with 20g protein. Great taste, low sugar.',
                'price' => 24.99,
                'stock' => 100,
                'category_id' => Categorie::where('name', 'Food & Drinks')->first()->id,
                'post_id' => Post::where('title', 'Top Protein Bars for Your Workout')->first()->id,
            ],
            [
                'name' => 'Adidas Ultraboost',
                'description' => 'Premium running shoe with responsive BOOST cushioning and Primeknit upper.',
                'price' => 179.99,
                'stock' => 30,
                'category_id' => Categorie::where('name', 'Sports')->first()->id,
                'post_id' => Post::where('title', 'Adidas Ultraboost: Running Shoe Review')->first()->id,
            ],
            [
                'name' => 'SteelSeries Arctis Nova 1',
                'description' => 'Budget gaming headset with best-in-class microphone quality.',
                'price' => 59.99,
                'stock' => 45,
                'category_id' => Categorie::where('name', 'Gaming')->first()->id,
                'post_id' => Post::where('title', 'Best Gaming Headsets Under €100')->first()->id,
            ],
        ];

        foreach ($products as $productData) {
            Product::create(array_merge($productData, [
                'user_id' => $admin->id,
            ]));
        }
    }
}
