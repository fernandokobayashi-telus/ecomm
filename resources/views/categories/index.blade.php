@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">

    <h1 class="text-2xl font-bold mb-8">Categories</h1>

    @if ($categories->isEmpty())
        <p class="text-gray-500 text-sm">No categories available yet.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category) }}"
                   class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition group">
                    <h2 class="font-semibold text-gray-900 group-hover:underline">{{ $category->title }}</h2>
                    @if ($category->children->isNotEmpty())
                        <p class="text-sm text-gray-500 mt-1">{{ $category->children->count() }} subcategories</p>
                    @endif
                </a>
            @endforeach
        </div>
    @endif

</div>
@endsection
