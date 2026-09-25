<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        $posts = [
            [
                'title' => 'iPhone 16 Pro Review',
                'content' => 'The iPhone 16 Pro brings a stunning titanium design, A18 Pro chip, and an improved 48MP camera system. Battery life has seen a significant boost, making it one of the best smartphones on the market. The Action Button adds useful customisation, and the larger display is gorgeous for media consumption.',
                'category_id' => Categorie::where('name', 'Electronics')->first()->id,
                'tags' => ['Premium', 'Must-have'],
            ],
            [
                'title' => 'Top 5 Budget Laptops for Students',
                'content' => 'Looking for an affordable laptop that can handle schoolwork and light gaming? We tested 15 models and narrowed it down to 5. The Lenovo IdeaPad 3 stands out with its Ryzen 5 processor and 8GB RAM at under €500. The Acer Aspire 5 is another solid pick for its build quality and keyboard.',
                'category_id' => Categorie::where('name', 'Electronics')->first()->id,
                'tags' => ['Budget-friendly', 'Recommended'],
            ],
            [
                'title' => 'Nike Air Max 90: Still Worth It?',
                'content' => 'The Nike Air Max 90 has been a cultural icon since 1990. We revisit this classic sneaker to see if it holds up in 2026. Spoiler: it absolutely does. The timeless design, comfortable Air sole, and endless colourway options make it a wardrobe staple.',
                'category_id' => Categorie::where('name', 'Clothing')->first()->id,
                'tags' => ['Bestseller', 'Trending'],
            ],
            [
                'title' => 'Best Gaming Headsets Under €100',
                'content' => 'Great audio does not have to break the bank. We tested the top gaming headsets under €100 and found some real gems. The HyperX Cloud II still reigns supreme for comfort, while the SteelSeries Arctis Nova 1 offers the best microphone quality in this range.',
                'category_id' => Categorie::where('name', 'Gaming')->first()->id,
                'tags' => ['Budget-friendly', 'Value pick'],
            ],
            [
                'title' => 'Review: IKEA KALLAX Shelf Unit',
                'content' => 'The IKEA KALLAX is one of the most versatile storage solutions available. Whether used as a room divider, bookshelf, or TV stand, it delivers clean Scandinavian design at an unbeatable price. Assembly takes about 45 minutes and the result looks great in any room.',
                'category_id' => Categorie::where('name', 'Home & Living')->first()->id,
                'tags' => ['Value pick', 'Recommended'],
            ],
            [
                'title' => 'Top Protein Bars for Your Workout',
                'content' => 'We taste-tested 10 popular protein bars to find the best options for pre and post-workout fuel. The Barebells Protein Bar leads the pack with 20g of protein and incredible taste. For a more natural option, try the BUFF Bar with its clean ingredient list.',
                'category_id' => Categorie::where('name', 'Food & Drinks')->first()->id,
                'tags' => ['Trending', 'Must-have'],
            ],
            [
                'title' => 'PS5 Pro vs Xbox Series X: Which to Buy?',
                'content' => 'The console war continues with the PS5 Pro pushing ray tracing to new heights while the Xbox Series X offers incredible value with Game Pass. We break down performance, exclusive games, and value for money to help you decide.',
                'category_id' => Categorie::where('name', 'Gaming')->first()->id,
                'tags' => ['Premium', 'Trending'],
            ],
            [
                'title' => 'Adidas Ultraboost: Running Shoe Review',
                'content' => 'The Adidas Ultraboost remains one of the most popular running shoes globally. With responsive BOOST cushioning and a Primeknit upper, it delivers comfort for both daily runs and casual wear. The latest version improves energy return by 4%.',
                'category_id' => Categorie::where('name', 'Sports')->first()->id,
                'tags' => ['Bestseller', 'Premium'],
            ],
        ];

        foreach ($posts as $postData) {
            $tags = $postData['tags'];
            unset($postData['tags']);

            $postData['user_id'] = $admin->id;
            $post = Post::create($postData);

            foreach ($tags as $tagName) {
                $tag = Tag::where('name', $tagName)->first();
                if ($tag) {
                    $post->tags()->attach($tag);
                }
            }
        }
    }
}
