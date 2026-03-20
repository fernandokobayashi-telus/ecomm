@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">

    <a href="{{ route('admin.users.index') }}"
       class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-800 transition mb-6">
        ← Back to Users
    </a>

    <h1 class="text-2xl font-bold mb-8">Edit User</h1>

    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full name</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('name') border-red-400 @enderror"
                >
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('email') border-red-400 @enderror"
                >
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select
                    id="role"
                    name="role"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('role') border-red-400 @enderror"
                >
                    @foreach ($roles as $roleOption)
                        <option
                            value="{{ $roleOption->value }}"
                            {{ old('role', $user->role->value) === $roleOption->value ? 'selected' : '' }}
                        >
                            {{ ucwords(str_replace('_', ' ', $roleOption->value)) }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-1">
                <button type="submit" class="bg-gray-900 text-white rounded-lg px-5 py-2 text-sm font-medium hover:bg-gray-700 transition">
                    Save changes
                </button>
            </div>
        </form>
    </div>

    {{-- Read-only user info --}}
    <div class="bg-gray-50 rounded-xl border border-gray-200 px-5 py-4 text-sm text-gray-500 space-y-1">
        @if ($user->phone_number)
            <p><span class="font-medium text-gray-700">Phone:</span> {{ $user->phone_number }}</p>
        @endif
        <p><span class="font-medium text-gray-700">Member since:</span> {{ $user->created_at->format('M j, Y') }}</p>
    </div>

</div>
@endsection
