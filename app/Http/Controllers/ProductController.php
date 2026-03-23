<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }

    public function show(Product $product): View
    {
        $product->load('categories');

        return view('products.show', compact('product'));
    }
}
