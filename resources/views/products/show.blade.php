@extends('layouts.main')
@section('title', $product->name)

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-5">
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}" class="img-fluid rounded shadow" alt="{{ $product->name }}">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center shadow" style="height:350px;">
                    <span class="text-muted" style="font-size:5rem;">📦</span>
                </div>
            @endif
        </div>
        <div class="col-md-7">
            <span class="badge bg-secondary">{{ $product->category->name ?? 'Tanpa Kategori' }}</span>
            <h1 class="mt-2">{{ $product->name }}</h1>
            <h3 class="text-primary">{{ $product->formatted_price }}</h3>

            <p>Stok:
                @if($product->stock > 10)
                    <span class="text-success fw-bold">{{ $product->stock }} tersedia</span>
                @elseif($product->stock > 0)
                    <span class="text-warning fw-bold">{{ $product->stock }} (menipis)</span>
                @else
                    <span class="text-danger fw-bold">Habis</span>
                @endif
            </p>

            <hr>
            <p>{{ $product->description ?? 'Belum ada deskripsi.' }}</p>

            @if($product->tags->count() > 0)
                <div class="mt-3">
                    @foreach($product->tags as $tag)
                        <span class="badge bg-info">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif

            <div class="mt-4">
                @can('update', $product)
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                @endcan
                @can('delete', $product)
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
                    </form>
                @endcan
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
