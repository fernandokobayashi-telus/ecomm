@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">

    <a href="{{ route('admin.categories.index') }}"
       class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-800 transition mb-6">
        ← Back to Categories
    </a>

    <h1 class="text-2xl font-bold mb-8">Edit Category</h1>

    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input id="title" type="text" name="title" value="{{ old('title', $category->title) }}" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('title') border-red-400 @enderror">
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Parent category <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                <select id="parent_id" name="parent_id"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('parent_id') border-red-400 @enderror">
                    <option value="">— None (top-level) —</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}"
                            {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->parent_id ? '└ ' : '' }}{{ $parent->title }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Max depth: 2 levels (root → child → grandchild)</p>
            </div>

            <div class="pt-1">
                <button type="submit" class="bg-gray-900 text-white rounded-lg px-5 py-2 text-sm font-medium hover:bg-gray-700 transition">
                    Save changes
                </button>
            </div>
        </form>
    </div>

    <div class="bg-gray-50 rounded-xl border border-gray-200 px-5 py-4 text-sm text-gray-500 space-y-1">
        <p><span class="font-medium text-gray-700">Slug:</span> <span class="font-mono text-xs">{{ $category->slug }}</span></p>
        <p><span class="font-medium text-gray-700">Created:</span> {{ $category->created_at->format('M j, Y') }}</p>
    </div>

</div>
@endsection
