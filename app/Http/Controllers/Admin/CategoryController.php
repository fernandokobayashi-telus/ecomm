<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::whereNull('parent_id')
            ->with('children.children')
            ->orderBy('title')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $parents = $this->eligibleParents();

        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        if ($data['parent_id']) {
            $this->enforceDepth($data['parent_id']);
        }

        $data['slug'] = $this->uniqueSlug(Str::slug($data['title']));

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('status', 'category-created');
    }

    public function edit(Category $category): View
    {
        $parents = $this->eligibleParents($category->id);

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate($this->rules());

        if ($data['parent_id']) {
            $this->enforceDepth($data['parent_id']);
        }

        if ($data['title'] !== $category->title) {
            $data['slug'] = $this->uniqueSlug(Str::slug($data['title']), $category->id);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'category-updated');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'category-deleted');
    }

    private function rules(): array
    {
        return [
            'title'     => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
        ];
    }

    private function enforceDepth(int $parentId): void
    {
        $parent = Category::with('parent')->findOrFail($parentId);

        // parent must be at depth 0 or 1 (its own parent must be null or itself top-level)
        abort_if(
            $parent->parent_id !== null && $parent->parent?->parent_id !== null,
            422,
            'Cannot nest categories more than 2 levels deep.'
        );
    }

    private function eligibleParents(?int $excludeId = null): \Illuminate\Database\Eloquent\Collection
    {
        // Only root categories and first-level children can be parents (depth 0 or 1)
        return Category::where(function ($q) {
            $q->whereNull('parent_id')
              ->orWhereHas('parent', fn ($q) => $q->whereNull('parent_id'));
        })
        ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
        ->orderBy('title')
        ->get();
    }

    private function uniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $original = $slug;
        $counter = 2;

        while (Category::where('slug', $slug)
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->exists()
        ) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }
}
