<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ecomm') }}</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 flex items-center justify-between h-14">
            <a href="{{ url('/') }}" class="font-semibold text-lg tracking-tight">
                {{ config('app.name', 'Shop') }}
            </a>

            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 transition">Products</a>
                <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-gray-900 transition">Categories</a>
                @auth
                    @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 transition">Admin</a>
                    @endif
                    @if(auth()->user()->canManageProducts())
                        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900 transition">Manage products</a>
                    @endif
                    <span class="text-gray-600">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-800 transition">
                            Log out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 transition">Log in</a>
                    <a href="{{ route('register') }}" class="bg-gray-900 text-white px-3 py-1.5 rounded-md hover:bg-gray-700 transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-10">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 text-sm">

                <div>
                    <p class="font-bold text-gray-900 mb-3">{{ config('app.name', 'Shop') }}</p>
                    <p class="text-gray-500 text-xs leading-relaxed">
                        Quality products delivered to your door. Shop with confidence.
                    </p>
                </div>

                <div>
                    <p class="font-semibold text-gray-700 mb-3 uppercase tracking-wider text-xs">Company</p>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-500 hover:text-gray-900 transition-colors">About</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900 transition-colors">Careers</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900 transition-colors">Press</a></li>
                    </ul>
                </div>

                <div>
                    <p class="font-semibold text-gray-700 mb-3 uppercase tracking-wider text-xs">Support</p>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-500 hover:text-gray-900 transition-colors">Contact</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900 transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900 transition-colors">Returns</a></li>
                    </ul>
                </div>

                <div>
                    <p class="font-semibold text-gray-700 mb-3 uppercase tracking-wider text-xs">Legal</p>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-500 hover:text-gray-900 transition-colors">Privacy</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900 transition-colors">Terms</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900 transition-colors">Cookie Policy</a></li>
                    </ul>
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row
                        items-center justify-between gap-2 text-xs text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Shop') }}. All rights reserved.</p>
                <p>Built with Laravel</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
