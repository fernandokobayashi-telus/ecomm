<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_H01_home_page_returns_200_for_unauthenticated_user(): void
    {
        $this->get(route('home'))->assertStatus(200);
    }

    public function test_H02_hero_banner_section_is_present(): void
    {
        $this->get(route('home'))->assertSee('Shop the Latest Trends');
    }

    public function test_H03_featured_products_shows_product_title(): void
    {
        Product::factory()->withImage()->create(['title' => 'Unique Test Widget']);

        $this->get(route('home'))->assertSee('Unique Test Widget');
    }

    public function test_H03_featured_products_shows_formatted_price(): void
    {
        Product::factory()->withImage()->create(['price' => 2999]);

        $this->get(route('home'))->assertSee('$29.99');
    }

    public function test_H04_featured_categories_shows_root_category(): void
    {
        Category::factory()->create(['title' => 'Electronics']);

        $this->get(route('home'))->assertSee('Electronics');
    }

    public function test_H05_new_arrivals_heading_is_present(): void
    {
        $this->get(route('home'))->assertSee('New Arrivals');
    }

    public function test_H05_new_arrivals_shows_recent_product(): void
    {
        Product::factory()->withImage()->create(['title' => 'Brand New Gadget']);

        $this->get(route('home'))->assertSee('Brand New Gadget');
    }

    public function test_H06_newsletter_section_is_present(): void
    {
        $this->get(route('home'))->assertSee('Subscribe');
    }

    public function test_H07_footer_contains_about_link(): void
    {
        $this->get(route('home'))->assertSee('About');
    }

    // Verifies the footer is rendered site-wide via layouts/app.blade.php, not just on home
    public function test_H07_footer_appears_on_products_page(): void
    {
        $this->get(route('products.index'))->assertSee('About');
    }

    public function test_H08_sidebar_shows_root_category(): void
    {
        Category::factory()->create(['title' => 'Furniture']);

        $this->get(route('home'))->assertSee('Furniture');
    }

    public function test_H08_sidebar_shows_child_categories_in_markup(): void
    {
        $parent = Category::factory()->create(['title' => 'Sports']);
        Category::factory()->asChild($parent)->create(['title' => 'Running']);

        $this->get(route('home'))->assertSee('Running');
    }
}
