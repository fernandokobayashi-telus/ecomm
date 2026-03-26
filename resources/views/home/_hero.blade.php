{{-- Hero Banner Carousel --}}
<div class="relative w-full overflow-hidden bg-gray-900" id="hero-carousel">

    <div id="hero-slides"
         class="flex transition-transform duration-500 ease-in-out"
         style="transform: translateX(0%);">

        {{-- Slide 1 --}}
        <div class="relative min-w-full h-[420px] sm:h-[500px] flex-shrink-0">
            <img src="https://picsum.photos/seed/hero1/1400/500"
                 alt="Summer Collection"
                 class="absolute inset-0 w-full h-full object-cover opacity-70">
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                <span class="text-xs font-semibold tracking-widest text-indigo-300 uppercase mb-3">New Season</span>
                <h2 class="text-3xl sm:text-5xl font-bold text-white leading-tight drop-shadow-lg">
                    Shop the Latest Trends
                </h2>
                <p class="mt-4 text-base sm:text-lg text-gray-200 max-w-xl">
                    Discover curated collections at unbeatable prices. Free shipping on orders over $50.
                </p>
                <a href="{{ route('products.index') }}"
                   class="mt-8 inline-block bg-white text-gray-900 font-semibold px-8 py-3 rounded-full
                          hover:bg-indigo-600 hover:text-white transition-colors duration-200 shadow-lg">
                    Shop Now
                </a>
            </div>
        </div>

        {{-- Slide 2 --}}
        <div class="relative min-w-full h-[420px] sm:h-[500px] flex-shrink-0">
            <img src="https://picsum.photos/seed/hero2/1400/500"
                 alt="Tech Deals"
                 class="absolute inset-0 w-full h-full object-cover opacity-70">
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                <span class="text-xs font-semibold tracking-widest text-yellow-300 uppercase mb-3">Up to 40% Off</span>
                <h2 class="text-3xl sm:text-5xl font-bold text-white leading-tight drop-shadow-lg">
                    Tech Deals This Week
                </h2>
                <p class="mt-4 text-base sm:text-lg text-gray-200 max-w-xl">
                    Laptops, phones, accessories — everything you need, all in one place.
                </p>
                <a href="{{ route('products.index') }}"
                   class="mt-8 inline-block bg-yellow-400 text-gray-900 font-semibold px-8 py-3 rounded-full
                          hover:bg-yellow-300 transition-colors duration-200 shadow-lg">
                    Explore Deals
                </a>
            </div>
        </div>

        {{-- Slide 3 --}}
        <div class="relative min-w-full h-[420px] sm:h-[500px] flex-shrink-0">
            <img src="https://picsum.photos/seed/hero3/1400/500"
                 alt="Home and Living"
                 class="absolute inset-0 w-full h-full object-cover opacity-70">
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
                <span class="text-xs font-semibold tracking-widest text-emerald-300 uppercase mb-3">Home & Living</span>
                <h2 class="text-3xl sm:text-5xl font-bold text-white leading-tight drop-shadow-lg">
                    Transform Your Space
                </h2>
                <p class="mt-4 text-base sm:text-lg text-gray-200 max-w-xl">
                    Beautiful furniture and decor. Delivered to your door.
                </p>
                <a href="{{ route('categories.index') }}"
                   class="mt-8 inline-block bg-emerald-500 text-white font-semibold px-8 py-3 rounded-full
                          hover:bg-emerald-400 transition-colors duration-200 shadow-lg">
                    Browse Categories
                </a>
            </div>
        </div>

    </div>

    {{-- Prev arrow --}}
    <button id="hero-prev" aria-label="Previous slide"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-black/40 hover:bg-black/70
                   text-white rounded-full w-10 h-10 flex items-center justify-center
                   transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    {{-- Next arrow --}}
    <button id="hero-next" aria-label="Next slide"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-black/40 hover:bg-black/70
                   text-white rounded-full w-10 h-10 flex items-center justify-center
                   transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- Dot indicators --}}
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex gap-2" id="hero-dots">
        <button aria-label="Slide 1" data-index="0"
                class="w-2.5 h-2.5 rounded-full bg-white" style="opacity:1"></button>
        <button aria-label="Slide 2" data-index="1"
                class="w-2.5 h-2.5 rounded-full bg-white" style="opacity:0.5"></button>
        <button aria-label="Slide 3" data-index="2"
                class="w-2.5 h-2.5 rounded-full bg-white" style="opacity:0.5"></button>
    </div>

</div>

@push('scripts')
<script>
(function () {
    var TOTAL = 3, INTERVAL = 5000;
    var slides  = document.getElementById('hero-slides');
    var dots    = document.querySelectorAll('#hero-dots [data-index]');
    var prevBtn = document.getElementById('hero-prev');
    var nextBtn = document.getElementById('hero-next');
    var current = 0, timer = null;

    function goTo(index) {
        current = (index + TOTAL) % TOTAL;
        slides.style.transform = 'translateX(-' + (current * 100) + '%)';
        dots.forEach(function (d, i) { d.style.opacity = i === current ? '1' : '0.5'; });
    }

    function start() { timer = setInterval(function () { goTo(current + 1); }, INTERVAL); }
    function reset() { clearInterval(timer); start(); }

    prevBtn.addEventListener('click', function () { goTo(current - 1); reset(); });
    nextBtn.addEventListener('click', function () { goTo(current + 1); reset(); });
    dots.forEach(function (d) {
        d.addEventListener('click', function () { goTo(parseInt(d.dataset.index, 10)); reset(); });
    });

    var carousel = document.getElementById('hero-carousel');
    carousel.addEventListener('mouseenter', function () { clearInterval(timer); });
    carousel.addEventListener('mouseleave', start);

    start();
}());
</script>
@endpush
