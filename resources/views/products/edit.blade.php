@extends('layouts.app')
@section('title', 'Edit: ' . $product->name)

@section('content')
    <h1>Edit Produk</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Periksa input kamu:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('products._form')

        @if($product->image)
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label><br>
                <img src="{{ Storage::url($product->image) }}" width="150" class="rounded">
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Update Produk</button>
        <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
