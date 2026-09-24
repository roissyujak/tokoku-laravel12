@props(['product'])

<div class="card h-100 shadow-sm">
    @if($product->image)
        <img src="{{ Storage::url($product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:200px;object-fit:cover;">
    @else
        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
            <span class="text-muted fs-1">📦</span>
        </div>
    @endif
    <div class="card-body d-flex flex-column">
        <span class="badge bg-secondary mb-2 align-self-start">
            {{ $product->category->name ?? 'Tanpa Kategori' }}
        </span>
        <h5 class="card-title">{{ $product->name }}</h5>
        <p class="card-text fw-bold text-primary fs-5">{{ $product->formatted_price }}</p>
        <p class="text-muted small">Stok: {{ $product->stock }}</p>
        <div class="mt-auto">
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm w-100">
                Lihat Detail
            </a>
        </div>
    </div>
</div>
