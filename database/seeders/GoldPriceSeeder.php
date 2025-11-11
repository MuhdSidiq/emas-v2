<?php

namespace Database\Seeders;

use App\Models\GoldPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class GoldPriceSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GoldPrice::factory(30)->sequence(fn (Sequence $sequence) => [
            'created_at' => now()->subHours($sequence->index),
        ])->create();
    }
}
