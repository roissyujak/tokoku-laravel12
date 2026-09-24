@extends('layouts.main')
@section('title', 'Tambah Produk')

@section('content')
    <h1>Tambah Produk Baru</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Periksa input kamu:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('products._form')
        <button type="submit" class="btn btn-primary">Simpan Produk</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
