@extends('layouts.app')
@section('title', 'Daftar Produk')

@section('content')
    <h1 class="mb-4">Daftar Produk</h1>

    {{-- Search & Filter --}}
    <form action="{{ route('products.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" class="form-control" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select class="form-select" name="category">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control" name="min_price" placeholder="Harga min" value="{{ request('min_price') }}">
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control" name="max_price" placeholder="Harga max" value="{{ request('max_price') }}">
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </div>
    </form>

    {{-- Product Grid --}}
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 col-lg-3 mb-4">
                <x-product-card :product="$product" />
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">😕 Belum ada produk yang ditemukan.</p>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Reset Filter</a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $products->withQueryString()->links() }}
    </div>
@endsection
