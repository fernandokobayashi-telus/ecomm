{{-- Featured Categories --}}
<section aria-labelledby="featured-categories-heading">

    <h2 id="featured-categories-heading" class="text-xl font-bold text-gray-900 mb-5">
        Shop by Category
    </h2>

    @if ($categories->isEmpty())
        <p class="text-sm text-gray-400">No categories available yet.</p>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category) }}"
                   class="group flex flex-col items-center bg-white border border-gray-200 rounded-xl
                          p-5 hover:shadow-md hover:border-indigo-300 transition-all duration-200">
                    <img src="https://picsum.photos/seed/cat{{ $category->id }}/160/160"
                         alt="{{ $category->title }}"
                         class="w-16 h-16 rounded-full object-cover mb-3
                                group-hover:scale-105 transition-transform duration-200">
                    <span class="text-sm font-semibold text-gray-800 text-center
                                 group-hover:text-indigo-600 transition-colors">
                        {{ $category->title }}
                    </span>
                    @if ($category->children->isNotEmpty())
                        <span class="mt-1 text-xs text-gray-400">
                            {{ $category->children->count() }} subcategories
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    @endif

</section>
