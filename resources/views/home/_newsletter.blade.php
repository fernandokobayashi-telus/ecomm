{{-- Newsletter Signup --}}
<section aria-labelledby="newsletter-heading"
         class="bg-indigo-600 rounded-2xl px-6 py-10 sm:px-10 text-center">

    <h2 id="newsletter-heading" class="text-2xl font-bold text-white">
        Stay in the Loop
    </h2>
    <p class="mt-2 text-indigo-200 text-sm max-w-md mx-auto">
        Get the latest deals, new arrivals, and exclusive offers delivered to your inbox.
    </p>

    <form action="#" method="POST"
          class="mt-6 flex flex-col sm:flex-row gap-3 max-w-md mx-auto"
          onsubmit="return false;">
        @csrf
        <label for="newsletter-email" class="sr-only">Email address</label>
        <input type="email"
               id="newsletter-email"
               name="email"
               placeholder="you@example.com"
               required
               class="flex-1 rounded-lg px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400
                      border-0 focus:outline-none focus:ring-2 focus:ring-white">
        <button type="submit"
                class="bg-white text-indigo-600 font-semibold text-sm px-6 py-2.5
                       rounded-lg hover:bg-indigo-50 transition-colors duration-150 shrink-0">
            Subscribe
        </button>
    </form>

</section>
