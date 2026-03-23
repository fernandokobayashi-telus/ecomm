@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">

    <h1 class="text-2xl font-bold mb-8">Products</h1>

    @if ($products->isEmpty())
        <p class="text-gray-500 text-sm">No products available yet.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <a href="{{ route('products.show', $product) }}"
                   class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition group">

                    @if ($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->title }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-300 text-sm">
                            No image
                        </div>
                    @endif

                    <div class="p-4">
                        <h2 class="font-semibold text-gray-900 group-hover:underline">{{ $product->title }}</h2>
                        @if ($product->short_description)
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $product->short_description }}</p>
                        @endif
                        <p class="text-sm font-semibold text-gray-900 mt-3">{{ $product->formatted_price }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>
@endsection
