<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Shop') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 flex items-center justify-between h-14">
            <a href="{{ url('/') }}" class="font-semibold text-lg tracking-tight">
                {{ config('app.name', 'Shop') }}
            </a>

            <div class="flex items-center gap-4 text-sm">
                @auth
                    @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 transition">Admin</a>
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

</body>
</html>
