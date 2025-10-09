<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $variant = ProductVariant::where('product_id', $product->id_product)->inRandomOrder()->first();

        if (!$variant) {
            $variant = ProductVariant::factory()->create(['product_id' => $product->id_product]);
        }

        $qty = fake()->numberBetween(1, 5);
        $price = $variant->price;
        $subtotal = $qty * $price;

        return [
            'order_id' => Order::inRandomOrder()->first()?->id_order ?? Order::factory(),
            'product_id' => $product->id_product,
            'variant_id' => $variant->id_variant,
            'qty' => $qty,
            'price' => $price,
            'subtotal' => $subtotal,
        ];
    }
}
