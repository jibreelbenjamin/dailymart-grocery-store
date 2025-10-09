<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;

class CartFactory extends Factory
{
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $variant = ProductVariant::where('product_id', $product->id_product)->inRandomOrder()->first();

        if (!$variant) {
            $variant = ProductVariant::factory()->create(['product_id' => $product->id_product]);
        }

        return [
            'user_id' => User::inRandomOrder()->first()?->id_user ?? User::factory(),
            'product_id' => $product->id_product,
            'variant_id' => $variant->id_variant,
            'stock' => fake()->numberBetween(1, 5),
        ];
    }
}
