<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GoldPrice>
 */
class GoldPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pricePerTroyOunce = fake()->randomFloat(2, 8000, 12000);

        return [
            'price_per_troy_ounce' => $pricePerTroyOunce,
            'price_per_gram' => round($pricePerTroyOunce / 31.1035, 2),
            'currency' => 'MYR',
            'source' => 'Metal Price API',
            'created_at' => now(),
        ];
    }
}
