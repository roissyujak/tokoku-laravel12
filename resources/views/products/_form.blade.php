<div class="mb-3">
    <label for="name" class="form-label">Nama Produk *</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror"
           name="name" value="{{ old('name', $product->name ?? '') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="category_id" class="form-label">Kategori *</label>
    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
        <option value="">Pilih Kategori</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Harga (Rp) *</label>
        <input type="number" class="form-control @error('price') is-invalid @enderror"
               name="price" value="{{ old('price', $product->price ?? '') }}" min="0">
        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Stok *</label>
        <input type="number" class="form-control @error('stock') is-invalid @enderror"
               name="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0">
        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea class="form-control" name="description" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Gambar Produk</label>
    <input type="file" class="form-control @error('image') is-invalid @enderror"
           name="image" accept="image/*">
    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
    <small class="text-muted">Format: JPG, PNG, WebP. Maks: 2MB.</small>
</div>

@isset($tags)
    <div class="mb-3">
        <label class="form-label d-block">Tag</label>
        @foreach($tags as $tag)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="tags[]"
                       value="{{ $tag->id }}" id="tag-{{ $tag->id }}"
                       {{ in_array($tag->id, old('tags', isset($product) ? $product->tags->pluck('id')->all() : [])) ? 'checked' : '' }}>
                <label class="form-check-label" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
            </div>
        @endforeach
    </div>
@endisset
