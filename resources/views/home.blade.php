@extends('layouts.app')

@section('content')

@include('home._hero')

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-64 shrink-0">
            @include('home._sidebar', ['categories' => $categories])
        </aside>

        <div class="flex-1 min-w-0 space-y-14">
            @include('home._featured-categories', ['categories' => $categories])
            @include('home._featured-products', ['featuredProducts' => $featuredProducts])
            @include('home._new-arrivals', ['newArrivals' => $newArrivals])
            @include('home._newsletter')
        </div>

    </div>
</div>

@endsection
