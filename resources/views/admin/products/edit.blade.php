@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">

    <a href="{{ route('admin.products.index') }}"
       class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-800 transition mb-6">
        ← Back to Products
    </a>

    <h1 class="text-2xl font-bold mb-8">Edit Product</h1>

    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input id="title" type="text" name="title" value="{{ old('title', $product->title) }}" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('title') border-red-400 @enderror">
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">
                    Short description <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                <input id="short_description" type="text" name="short_description"
                    value="{{ old('short_description', $product->short_description) }}"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('short_description') border-red-400 @enderror">
                @error('short_description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="5" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('description') border-red-400 @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                    Price <span class="text-gray-400 font-normal">(in cents — e.g. 1999 for $19.99)</span>
                </label>
                <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" min="0" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('price') border-red-400 @enderror">
                @error('price')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                    Image URL <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                <input id="image" type="url" name="image" value="{{ old('image', $product->image) }}" placeholder="https://..."
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('image') border-red-400 @enderror">
                @error('image')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Categories <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                @php $selectedIds = old('categories', $product->categories->pluck('id')->toArray()); @endphp
                <div class="space-y-3">
                    @foreach ($categories as $root)
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-800">
                                <input type="checkbox" name="categories[]" value="{{ $root->id }}"
                                    {{ in_array($root->id, $selectedIds) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                                {{ $root->title }}
                            </label>
                            @foreach ($root->children as $child)
                                <label class="flex items-center gap-2 text-sm text-gray-700 ml-6 mt-1">
                                    <input type="checkbox" name="categories[]" value="{{ $child->id }}"
                                        {{ in_array($child->id, $selectedIds) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                                    {{ $child->title }}
                                </label>
                                @foreach ($child->children as $grandchild)
                                    <label class="flex items-center gap-2 text-sm text-gray-600 ml-12 mt-1">
                                        <input type="checkbox" name="categories[]" value="{{ $grandchild->id }}"
                                            {{ in_array($grandchild->id, $selectedIds) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                                        {{ $grandchild->title }}
                                    </label>
                                @endforeach
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-1">
                <button type="submit" class="bg-gray-900 text-white rounded-lg px-5 py-2 text-sm font-medium hover:bg-gray-700 transition">
                    Save changes
                </button>
            </div>
        </form>
    </div>

    <div class="bg-gray-50 rounded-xl border border-gray-200 px-5 py-4 text-sm text-gray-500 space-y-1">
        <p><span class="font-medium text-gray-700">Slug:</span> <span class="font-mono text-xs">{{ $product->slug }}</span></p>
        <p><span class="font-medium text-gray-700">Created:</span> {{ $product->created_at->format('M j, Y') }}</p>
    </div>

</div>
@endsection
