<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::all();

        Product::factory()->count(50)->create()->each(function ($product) use ($tags) {
            // Attach 1-3 random tags ke setiap produk
            $product->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
