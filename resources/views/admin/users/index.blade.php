@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold">
            Users
            <span class="text-base font-normal text-gray-400 ml-1">({{ $users->count() }})</span>
        </h1>
    </div>

    {{-- Flash messages --}}
    @if (session('status') === 'user-updated')
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            User updated successfully.
        </div>
    @elseif (session('status') === 'user-deleted')
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            User deleted.
        </div>
    @endif

    @if ($errors->has('delete'))
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
            {{ $errors->first('delete') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Name</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Email</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Role</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Joined</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $user->email }}</td>
                        <td class="px-5 py-3">
                            @php
                                $badgeClass = match($user->role) {
                                    \App\Enums\UserRole::SuperAdmin   => 'bg-gray-900 text-white',
                                    \App\Enums\UserRole::ProductAdmin => 'bg-blue-100 text-blue-700',
                                    \App\Enums\UserRole::SalesAdmin   => 'bg-purple-100 text-purple-700',
                                    default                           => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="inline-block text-xs font-medium px-2 py-0.5 rounded-full {{ $badgeClass }}">
                                {{ ucwords(str_replace('_', ' ', $user->role->value)) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-500">{{ $user->created_at->format('M j, Y') }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="text-gray-500 hover:text-gray-900 transition text-xs font-medium">
                                    Edit
                                </a>

                                @if ($user->id === auth()->id())
                                    <button type="button" disabled
                                        class="text-xs text-gray-300 cursor-not-allowed"
                                        title="You cannot delete your own account">
                                        Delete
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                          onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition font-medium">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
