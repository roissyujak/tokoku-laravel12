<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->words(rand(2, 4), true),
            'description' => fake()->paragraph(),
            'price'       => fake()->numberBetween(25000, 15000000),
            'stock'       => fake()->numberBetween(0, 200),
            'image'       => null,
            'is_active'   => fake()->boolean(85),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'user_id'     => User::whereIn('role', ['admin', 'seller'])->inRandomOrder()->value('id'),
        ];
    }
}
