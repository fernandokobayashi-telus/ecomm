@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold">
            Categories
            <span class="text-base font-normal text-gray-400 ml-1">({{ $categories->count() }})</span>
        </h1>
        <a href="{{ route('admin.categories.create') }}"
           class="bg-gray-900 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">
            Add category
        </a>
    </div>

    @if (session('status'))
        @php
            $messages = [
                'category-created' => 'Category created.',
                'category-updated' => 'Category updated.',
                'category-deleted' => 'Category deleted.',
            ];
        @endphp
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ $messages[session('status')] ?? 'Changes saved.' }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Title</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Slug</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Children</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($categories as $category)
                    {{-- Root row --}}
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $category->title }}</td>
                        <td class="px-5 py-3 text-gray-400 text-xs font-mono">{{ $category->slug }}</td>
                        <td class="px-5 py-3 text-gray-500 text-xs">{{ $category->children->count() }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="text-gray-500 hover:text-gray-900 transition text-xs font-medium">Edit</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                      onsubmit="return confirm('Delete \'{{ addslashes($category->title) }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    {{-- Level 1 children --}}
                    @foreach ($category->children as $child)
                        <tr class="bg-gray-50 hover:bg-gray-100 transition">
                            <td class="pl-10 pr-5 py-2.5 text-gray-700">
                                <span class="text-gray-300 mr-1">└</span>{{ $child->title }}
                            </td>
                            <td class="px-5 py-2.5 text-gray-400 text-xs font-mono">{{ $child->slug }}</td>
                            <td class="px-5 py-2.5 text-gray-500 text-xs">{{ $child->children->count() }}</td>
                            <td class="px-5 py-2.5">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.categories.edit', $child) }}"
                                       class="text-gray-500 hover:text-gray-900 transition text-xs font-medium">Edit</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $child) }}"
                                          onsubmit="return confirm('Delete \'{{ addslashes($child->title) }}\'?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {{-- Level 2 grandchildren --}}
                        @foreach ($child->children as $grandchild)
                            <tr class="bg-gray-50 hover:bg-gray-100 transition">
                                <td class="pl-16 pr-5 py-2.5 text-gray-600">
                                    <span class="text-gray-300 mr-1">└</span>{{ $grandchild->title }}
                                </td>
                                <td class="px-5 py-2.5 text-gray-400 text-xs font-mono">{{ $grandchild->slug }}</td>
                                <td class="px-5 py-2.5 text-xs text-gray-300">—</td>
                                <td class="px-5 py-2.5">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.categories.edit', $grandchild) }}"
                                           class="text-gray-500 hover:text-gray-900 transition text-xs font-medium">Edit</a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $grandchild) }}"
                                              onsubmit="return confirm('Delete \'{{ addslashes($grandchild->title) }}\'?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-gray-400 text-sm">
                            No categories yet.
                            <a href="{{ route('admin.categories.create') }}" class="text-gray-900 underline ml-1">Add one.</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
