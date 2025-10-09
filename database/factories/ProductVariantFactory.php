<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductVariantFactory extends Factory
{
    public function definition(): array
    {
        $variantName = fake()->randomElement(['Kecil', 'Sedang', 'Besar', '1kg', '500g', '250g', 'Rasa Pedas', 'Rasa Manis']);

        return [
            'product_id' => Product::inRandomOrder()->first()->id_product ?? Product::factory(),
            'name' => $variantName,
            'stock' => fake()->numberBetween(5, 100),
            'price' => fake()->numberBetween(5000, 80000),
        ];
    }
}
