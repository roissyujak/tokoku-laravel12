<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama produk wajib diisi!',
            'name.max'           => 'Nama produk maksimal 255 karakter.',
            'price.required'     => 'Harga wajib diisi!',
            'price.numeric'      => 'Harga harus berupa angka.',
            'price.min'          => 'Harga tidak boleh negatif.',
            'stock.required'     => 'Stok wajib diisi!',
            'stock.integer'      => 'Stok harus berupa bilangan bulat.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'image.image'        => 'File harus berupa gambar.',
            'image.max'          => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
