<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Supplier>
 */
class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'supplier_name' => $this->faker->company(),
            'cell_no' => $this->faker->phoneNumber(),
            'tel_no' => $this->faker->phoneNumber(),
            'contact_person' => $this->faker->name(),
            'email' => $this->faker->unique()->companyEmail(),
            'address' => $this->faker->address(),
            'country' => 'Pakistan', // Always use a country with a known currency
            'company_id' => Company::factory(),
        ];
    }
} 