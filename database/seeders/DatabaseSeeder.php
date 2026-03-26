<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        $electronics = Category::factory()->create(['title' => 'Electronics',   'slug' => 'electronics']);
        $clothing    = Category::factory()->create(['title' => 'Clothing',       'slug' => 'clothing']);
        $home        = Category::factory()->create(['title' => 'Home & Living',  'slug' => 'home-living']);
        $sports      = Category::factory()->create(['title' => 'Sports',         'slug' => 'sports']);
        Category::factory()->create(['title' => 'Books', 'slug' => 'books']);

        Category::factory()->asChild($electronics)->create(['title' => 'Laptops',     'slug' => 'laptops']);
        Category::factory()->asChild($electronics)->create(['title' => 'Phones',      'slug' => 'phones']);
        Category::factory()->asChild($electronics)->create(['title' => 'Accessories', 'slug' => 'accessories']);
        Category::factory()->asChild($clothing)->create(['title' => 'T-Shirts',  'slug' => 't-shirts']);
        Category::factory()->asChild($clothing)->create(['title' => 'Jackets',   'slug' => 'jackets']);
        Category::factory()->asChild($home)->create(['title' => 'Furniture', 'slug' => 'furniture']);
        Category::factory()->asChild($home)->create(['title' => 'Decor',     'slug' => 'decor']);

        $items = [
            ['title' => 'Pro Wireless Headphones', 'slug' => 'pro-wireless-headphones', 'price' => 8999,   'cat' => $electronics],
            ['title' => 'Ultrabook Laptop 15"',    'slug' => 'ultrabook-laptop-15',      'price' => 129999, 'cat' => $electronics],
            ['title' => 'Running Shoes X200',      'slug' => 'running-shoes-x200',       'price' => 5999,   'cat' => $sports],
            ['title' => 'Minimalist Desk Lamp',    'slug' => 'minimalist-desk-lamp',     'price' => 3499,   'cat' => $home],
            ['title' => 'Merino Wool Jacket',      'slug' => 'merino-wool-jacket',       'price' => 14999,  'cat' => $clothing],
            ['title' => 'Ceramic Coffee Mug Set',  'slug' => 'ceramic-coffee-mug-set',   'price' => 2499,   'cat' => $home],
            ['title' => 'Smart Watch Series 4',    'slug' => 'smart-watch-series-4',     'price' => 29999,  'cat' => $electronics],
            ['title' => 'Yoga Mat Premium',        'slug' => 'yoga-mat-premium',         'price' => 4599,   'cat' => $sports],
        ];

        foreach ($items as $data) {
            $product = Product::factory()->withImage()->create([
                'title'             => $data['title'],
                'slug'              => $data['slug'],
                'price'             => $data['price'],
                'short_description' => fake()->sentence(),
                'description'       => fake()->paragraphs(2, true),
            ]);
            $product->categories()->attach($data['cat']->id);
        }
    }
}
