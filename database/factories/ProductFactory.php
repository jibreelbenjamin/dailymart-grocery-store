<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Tomat Segar 1kg',
            'Daging Sapi Premium 500g',
            'Telur Ayam Kampung 10 Butir',
            'Susu Ultra Full Cream 1L',
            'Bawang Merah 250g',
            'Keripik Pisang Manis 150g',
            'Air Mineral 600ml',
            'Sabun Cuci Piring 400ml',
        ]);

        return [
            'category_id' => Category::inRandomOrder()->first()->id_cat ?? Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(10),
            'price' => fake()->numberBetween(5000, 100000),
            'stock' => fake()->numberBetween(10, 200),
            'image' => 'https://via.placeholder.com/300x300.png?text=' . urlencode($name),
        ];
    }
}
