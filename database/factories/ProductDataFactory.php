<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductData>
 */
class ProductDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price_per_gram' => fake()->randomFloat(2, 100, 500),
            'stock' => fake()->numberBetween(0, 1000),
            'low_stock_threshold' => fake()->numberBetween(5, 20),
        ];
    }
}
