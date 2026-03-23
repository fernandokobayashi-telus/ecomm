@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">

    <a href="{{ route('products.index') }}"
       class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-800 transition mb-6">
        ← Back to Products
    </a>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

        @if ($product->image)
            <img src="{{ $product->image }}" alt="{{ $product->title }}"
                 class="w-full h-72 object-cover">
        @else
            <div class="w-full h-72 bg-gray-100 flex items-center justify-center text-gray-300 text-sm">
                No image
            </div>
        @endif

        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900">{{ $product->title }}</h1>

            @if ($product->short_description)
                <p class="text-gray-500 mt-2">{{ $product->short_description }}</p>
            @endif

            <p class="text-xl font-semibold text-gray-900 mt-4">{{ $product->formatted_price }}</p>

            @if ($product->categories->isNotEmpty())
                <div class="flex flex-wrap gap-2 mt-3">
                    @foreach ($product->categories as $cat)
                        <a href="{{ route('categories.show', $cat) }}"
                           class="text-xs bg-gray-100 text-gray-600 rounded-full px-3 py-1 hover:bg-gray-200 transition">
                            {{ $cat->title }}
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Cart button — out of scope, no action --}}
            <button type="button" disabled
                class="mt-6 w-full bg-gray-200 text-gray-400 rounded-lg px-5 py-3 text-sm font-medium cursor-not-allowed">
                Add to cart — coming soon
            </button>

            @if ($product->description)
                <div class="mt-8 border-t border-gray-100 pt-6">
                    <h2 class="text-sm font-semibold text-gray-700 mb-3">Description</h2>
                    <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $product->description }}</div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
