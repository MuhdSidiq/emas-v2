<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::query()->upsert([
            [
                'name' => 'ADMIN',
                'description' => 'Full administrative access to all features.',
            ],
            [
                'name' => 'AGENT',
                'description' => 'Manages customer interactions and sales.',
            ],
            [
                'name' => 'CUSTOMER',
                'description' => 'Standard customer account with self-service access.',
            ],
            [
                'name' => 'STAFF',
                'description' => 'Internal staff member with operational permissions.',
            ],
        ], ['name'], ['description']);
    }
}
