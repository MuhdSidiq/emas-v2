<?php

namespace Database\Seeders;

use App\Models\ProfitMargin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfitMarginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $margins = [
            ['name' => 'Staff', 'rate' => 0.5],
            ['name' => 'Agent', 'rate' => 3.0],
        ];

        foreach ($margins as $margin) {
            ProfitMargin::updateOrCreate(
                ['name' => $margin['name']],
                ['rate' => $margin['rate']]
            );
        }
    }
}
