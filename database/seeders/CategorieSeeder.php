<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Phones, laptops, gadgets and other electronic devices'],
            ['name' => 'Clothing', 'description' => 'Fashion, apparel and accessories'],
            ['name' => 'Food & Drinks', 'description' => 'Restaurants, recipes, snacks and beverages'],
            ['name' => 'Gaming', 'description' => 'Consoles, games, peripherals and gaming gear'],
            ['name' => 'Home & Living', 'description' => 'Furniture, decor and household products'],
            ['name' => 'Sports', 'description' => 'Athletic equipment, fitness gear and sportswear'],
        ];

        foreach ($categories as $category) {
            Categorie::create($category);
        }
    }
}
