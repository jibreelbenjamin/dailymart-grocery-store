<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(7)->create();
        \App\Models\Product::factory(200)->create();
        \App\Models\ProductVariant::factory(375)->create();
        \App\Models\Cart::factory(150)->create();
        \App\Models\Order::factory(400)->create();
        \App\Models\OrderItem::factory(1250)->create();
    }
}
