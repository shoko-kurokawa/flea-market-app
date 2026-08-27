<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->word(),
            'brand_name' => fake()->optional()->company(),
            'description' => fake()->realText(100),
            'price' => fake()->numberBetween(100, 100000),
            'condition' => fake()->randomElement([
                '良好',
                '目立った傷や汚れなし',
                'やや傷や汚れあり',
                '状態が悪い',
            ]),
        ];
    }
}
