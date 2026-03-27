<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin user
        User::factory()->superAdmin()->create([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('admin123'),
        ]);

        // Dummy regular users
        User::factory()->count(5)->create();

        // Category tree: each root gets 3 subcategories, each node gets 5 products
        $tree = [
            ['title' => 'Electronics',   'slug' => 'electronics',  'children' => [
                ['title' => 'Laptops',     'slug' => 'laptops'],
                ['title' => 'Phones',      'slug' => 'phones'],
                ['title' => 'Accessories', 'slug' => 'accessories'],
            ]],
            ['title' => 'Clothing',      'slug' => 'clothing',     'children' => [
                ['title' => 'T-Shirts',    'slug' => 't-shirts'],
                ['title' => 'Jackets',     'slug' => 'jackets'],
                ['title' => 'Shoes',       'slug' => 'shoes'],
            ]],
            ['title' => 'Home & Living', 'slug' => 'home-living',  'children' => [
                ['title' => 'Furniture',   'slug' => 'furniture'],
                ['title' => 'Decor',       'slug' => 'decor'],
                ['title' => 'Kitchen',     'slug' => 'kitchen'],
            ]],
            ['title' => 'Sports',        'slug' => 'sports',       'children' => [
                ['title' => 'Running',     'slug' => 'running'],
                ['title' => 'Gym',         'slug' => 'gym'],
                ['title' => 'Cycling',     'slug' => 'cycling'],
            ]],
            ['title' => 'Books',         'slug' => 'books',        'children' => [
                ['title' => 'Fiction',     'slug' => 'fiction'],
                ['title' => 'Science',     'slug' => 'science'],
                ['title' => 'History',     'slug' => 'history'],
            ]],
        ];

        foreach ($tree as $rootData) {
            $root = Category::factory()->create([
                'title' => $rootData['title'],
                'slug'  => $rootData['slug'],
            ]);

            Product::factory()->withImage()->count(5)->create()->each(
                fn ($p) => $p->categories()->attach($root->id)
            );

            foreach ($rootData['children'] as $childData) {
                $child = Category::factory()->asChild($root)->create([
                    'title' => $childData['title'],
                    'slug'  => $childData['slug'],
                ]);

                Product::factory()->withImage()->count(5)->create()->each(
                    fn ($p) => $p->categories()->attach($child->id)
                );
            }
        }
    }
}
