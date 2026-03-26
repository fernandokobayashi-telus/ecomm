{{-- Featured Products --}}
<section aria-labelledby="featured-products-heading">

    <div class="flex items-center justify-between mb-5">
        <h2 id="featured-products-heading" class="text-xl font-bold text-gray-900">
            Featured Products
        </h2>
        <a href="{{ route('products.index') }}"
           class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
            View all →
        </a>
    </div>

    @if ($featuredProducts->isEmpty())
        <p class="text-sm text-gray-400">No featured products yet.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($featuredProducts as $product)
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden
                            hover:shadow-md transition-shadow duration-200 flex flex-col">

                    <div class="relative">
                        <img src="{{ $product->image }}"
                             alt="{{ $product->title }}"
                             class="w-full h-44 object-cover">
                        @if ($product->created_at->diffInDays(now()) <= 7)
                            <span class="absolute top-2 left-2 bg-indigo-600 text-white
                                         text-xs font-bold px-2 py-0.5 rounded-full">
                                New
                            </span>
                        @endif
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-gray-900 text-sm leading-snug line-clamp-2">
                            {{ $product->title }}
                        </h3>
                        <p class="mt-1 text-sm font-bold text-gray-900">
                            {{ $product->formatted_price }}
                        </p>
                        <div class="mt-auto pt-3">
                            <a href="{{ route('products.show', $product) }}"
                               class="block text-center text-sm font-semibold bg-gray-900 text-white
                                      rounded-lg px-4 py-2 hover:bg-indigo-600 transition-colors duration-150">
                                View product
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</section>
