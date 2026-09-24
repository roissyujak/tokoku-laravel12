<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Elektronik', 'Fashion Pria', 'Fashion Wanita',
            'Makanan & Minuman', 'Kesehatan', 'Olahraga',
            'Buku & Alat Tulis', 'Peralatan Rumah', 'Otomotif',
            'Mainan & Hobi',
        ]);

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => fake()->sentence(),
        ];
    }
}
