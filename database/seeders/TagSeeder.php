<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = ['Bestseller', 'Promo', 'New Arrival', 'Limited Edition',
                 'Diskon', 'Gratis Ongkir', 'Flash Sale', 'Trending'];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag, 'slug' => Str::slug($tag)]);
        }
    }
}
