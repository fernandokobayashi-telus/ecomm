@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold">
            Products
            <span class="text-base font-normal text-gray-400 ml-1">({{ $products->count() }})</span>
        </h1>
        <a href="{{ route('admin.products.create') }}"
           class="bg-gray-900 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">
            Add product
        </a>
    </div>

    @if (session('status'))
        @php
            $messages = [
                'product-created' => 'Product created.',
                'product-updated' => 'Product updated.',
                'product-deleted' => 'Product deleted.',
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
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Price</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-600">Slug</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 font-medium text-gray-900">
                            <a href="{{ route('products.show', $product) }}" target="_blank"
                               class="hover:underline">{{ $product->title }}</a>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $product->formatted_price }}</td>
                        <td class="px-5 py-3 text-gray-400 text-xs font-mono">{{ $product->slug }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="text-gray-500 hover:text-gray-900 transition text-xs font-medium">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                      onsubmit="return confirm('Delete \'{{ addslashes($product->title) }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-gray-400 text-sm">
                            No products yet.
                            <a href="{{ route('admin.products.create') }}" class="text-gray-900 underline ml-1">Add one.</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
