<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::whereNotNull('image')
            ->latest()
            ->take(8)
            ->get();

        $newArrivals = Product::latest()
            ->take(4)
            ->get();

        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('title')
            ->get();

        return view('home', compact('featuredProducts', 'newArrivals', 'categories'));
    }
}
