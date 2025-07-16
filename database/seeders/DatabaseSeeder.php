<?php

namespace Database\Seeders;

use App\Models\Company;
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
        $company = Company::firstOrCreate([
            'name' => 'Demo Company',
        ], [
            'type' => 'both',
            'cell_no' => '+1234567890',
            'email' => 'demo@company.com',
            'ntn' => '1234567',
            'tel_no' => '+0987654321',
            'taxCash' => 5.0,
            'taxCard' => 7.5,
            'taxOnline' => 3.0,
            'website' => 'https://demo-company.com',
            'address' => '123 Demo Street, City, Country',
        ]);
        $user = User::first();
        if ($user && !$user->company_id) {
            $user->company_id = $company->id;
            $user->save();
        }

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
