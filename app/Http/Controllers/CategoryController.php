<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::whereNull('parent_id')
            ->with('children.children')
            ->orderBy('title')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category): View
    {
        $category->load(['parent', 'children.children', 'products']);

        return view('categories.show', compact('category'));
    }
}
