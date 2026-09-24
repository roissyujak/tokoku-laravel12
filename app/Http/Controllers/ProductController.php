<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Daftar semua produk (dengan pencarian, filter, dan pengurutan).
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->active();

        // Pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Pengurutan: kolom dibatasi whitelist agar input user tidak masuk ke query mentah
        $sortable = ['name', 'price', 'stock', 'created_at'];
        $sortBy   = in_array($request->input('sort'), $sortable, true) ? $request->input('sort') : 'created_at';
        $sortDir  = $request->input('dir') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortDir);

        $products   = $query->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Form tambah produk.
     */
    public function create()
    {
        Gate::authorize('create', Product::class);

        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();

        return view('products.create', compact('categories', 'tags'));
    }

    /**
     * Simpan produk baru.
     */
    public function store(StoreProductRequest $request)
    {
        Gate::authorize('create', Product::class);

        $data = $request->validated();
        unset($data['tags']);

        // Upload gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['is_active'] = true;
        $data['user_id']   = $request->user()->id; // pemilik produk = user yang login

        $product = Product::create($data);
        $product->tags()->sync($request->input('tags', []));

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Detail produk.
     */
    public function show($id)
    {
        $product = Product::with(['category', 'tags'])->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Form edit produk.
     */
    public function edit($id)
    {
        $product = Product::with('tags')->findOrFail($id);
        Gate::authorize('update', $product);

        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories', 'tags'));
    }

    /**
     * Update produk.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('update', $product);

        $data = $request->validated();
        unset($data['tags']);

        // Upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        $product->tags()->sync($request->input('tags', []));

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Produk berhasil diupdate!');
    }

    /**
     * Hapus produk (hanya admin, lihat ProductPolicy).
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('delete', $product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
