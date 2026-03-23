<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::with('children.children')->whereNull('parent_id')->orderBy('title')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $data['slug'] = $this->uniqueSlug(Str::slug($data['title']));

        $product = Product::create($data);
        $product->categories()->sync($request->input('categories', []));

        return redirect()->route('admin.products.index')->with('status', 'product-created');
    }

    public function edit(Product $product): View
    {
        $categories = Category::with('children.children')->whereNull('parent_id')->orderBy('title')->get();
        $product->load('categories');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate($this->rules());

        if ($data['title'] !== $product->title) {
            $data['slug'] = $this->uniqueSlug(Str::slug($data['title']), $product->id);
        }

        $product->update($data);
        $product->categories()->sync($request->input('categories', []));

        return redirect()->route('admin.products.index')->with('status', 'product-updated');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'product-deleted');
    }

    private function rules(): array
    {
        return [
            'title'             => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['required', 'string'],
            'price'             => ['required', 'integer', 'min:0'],
            'image'             => ['nullable', 'url', 'max:255'],
        ];
    }

    private function uniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $original = $slug;
        $counter = 2;

        while (Product::where('slug', $slug)->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }
}
