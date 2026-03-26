{{-- New Arrivals --}}
<section aria-labelledby="new-arrivals-heading">

    <div class="flex items-center justify-between mb-5">
        <h2 id="new-arrivals-heading" class="text-xl font-bold text-gray-900">
            New Arrivals
        </h2>
        <a href="{{ route('products.index') }}"
           class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
            See all →
        </a>
    </div>

    @if ($newArrivals->isEmpty())
        <p class="text-sm text-gray-400">Check back soon for new arrivals.</p>
    @else
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($newArrivals as $product)
                <a href="{{ route('products.show', $product) }}"
                   class="group bg-white border border-gray-200 rounded-xl overflow-hidden
                          hover:shadow-md transition-shadow duration-200">
                    @if ($product->image)
                        <img src="{{ $product->image }}"
                             alt="{{ $product->title }}"
                             class="w-full h-40 object-cover group-hover:opacity-90 transition-opacity">
                    @else
                        <div class="w-full h-40 bg-gray-100 flex items-center justify-center
                                    text-gray-300 text-xs font-medium">
                            No image
                        </div>
                    @endif
                    <div class="p-3">
                        <p class="text-sm font-semibold text-gray-900 line-clamp-1
                                  group-hover:text-indigo-600 transition-colors">
                            {{ $product->title }}
                        </p>
                        <p class="text-sm text-gray-600 mt-0.5">{{ $product->formatted_price }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</section>
