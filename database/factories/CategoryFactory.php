<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Buah & Sayur',
            'Daging & Telur',
            'Susu & Produk Dingin',
            'Bumbu Dapur',
            'Snack & Makanan Ringan',
            'Minuman',
            'Perlengkapan Rumah'
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
