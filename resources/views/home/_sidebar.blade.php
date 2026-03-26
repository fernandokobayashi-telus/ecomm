{{-- Categories Sidebar --}}
<div class="bg-white border border-gray-200 rounded-xl p-5 sticky top-4">

    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">
        All Categories
    </h2>

    @if ($categories->isEmpty())
        <p class="text-xs text-gray-400">No categories yet.</p>
    @else
        <ul class="space-y-1">
            @foreach ($categories as $category)
                <li>
                    @if ($category->children->isNotEmpty())
                        <button type="button"
                                class="sidebar-toggle w-full flex items-center justify-between
                                       text-sm text-gray-700 hover:text-indigo-600 font-medium
                                       py-1.5 px-2 rounded-md hover:bg-gray-50 transition-colors"
                                data-target="children-{{ $category->id }}"
                                aria-expanded="false">
                            <a href="{{ route('categories.show', $category) }}"
                               class="hover:underline"
                               onclick="event.stopPropagation()">
                                {{ $category->title }}
                            </a>
                            <svg class="sidebar-chevron w-4 h-4 text-gray-400 transition-transform duration-200"
                                 xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <ul id="children-{{ $category->id }}"
                            class="hidden pl-4 mt-1 space-y-0.5 border-l border-gray-100">
                            @foreach ($category->children as $child)
                                <li>
                                    <a href="{{ route('categories.show', $child) }}"
                                       class="block text-sm text-gray-600 hover:text-indigo-600
                                              py-1 px-2 rounded-md hover:bg-gray-50 transition-colors">
                                        {{ $child->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <a href="{{ route('categories.show', $category) }}"
                           class="block text-sm text-gray-700 hover:text-indigo-600 font-medium
                                  py-1.5 px-2 rounded-md hover:bg-gray-50 transition-colors">
                            {{ $category->title }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

</div>

@push('scripts')
<script>
(function () {
    document.querySelectorAll('.sidebar-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var list    = document.getElementById(btn.getAttribute('data-target'));
            var chevron = btn.querySelector('.sidebar-chevron');
            var isOpen  = !list.classList.contains('hidden');
            list.classList.toggle('hidden', isOpen);
            chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            btn.setAttribute('aria-expanded', String(!isOpen));
        });
    });
}());
</script>
@endpush
