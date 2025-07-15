<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a company first
        $company = \App\Models\Company::factory()->create();

        // User::factory(10)->create();

        \App\Models\User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'company_id' => $company->id,
                'status' => 'active',
                'role' => 'superadmin',
            ]
        );
    }
}
