<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $status = ['paid', 'pending', 'complete', 'cancelled'];

        return [
            'user_id' => User::inRandomOrder()->first()->id_user ?? User::factory(),
            'total' => $this->faker->randomFloat(2, 100000, 2000000),
            'payment' => $this->faker->randomElement(['cod', 'bca', 'bri', 'bni', 'mandiri', 'qris']),
            'shipping_address' => $this->faker->address(),
            'tracking_number' => strtoupper($this->faker->unique()->regexify('[A-Z]{10}[0-9]{6}')),
            'status' => $this->faker->randomElement($status),
        ];
    }
}

