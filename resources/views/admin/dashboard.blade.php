@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
    <h1>Admin Dashboard</h1>
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary"><div class="card-body text-center">
                <h3>{{ $stats['total_products'] }}</h3><p class="mb-0">Total Produk</p>
            </div></div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success"><div class="card-body text-center">
                <h3>{{ $stats['active_products'] }}</h3><p class="mb-0">Produk Aktif</p>
            </div></div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info"><div class="card-body text-center">
                <h3>{{ $stats['total_categories'] }}</h3><p class="mb-0">Kategori</p>
            </div></div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning"><div class="card-body text-center">
                <h3>{{ $stats['total_users'] }}</h3><p class="mb-0">Users</p>
            </div></div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header"><strong>5 Produk Termahal</strong></div>
        <ul class="list-group list-group-flush">
            @foreach($stats['top_products'] as $p)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $p->name }}</span>
                    <span class="fw-bold">Rp {{ number_format($p->price) }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
