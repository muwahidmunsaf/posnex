<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_id' => \App\Models\Supplier::factory(),
            'purchase_date' => now()->toDateString(),
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
            'company_id' => \App\Models\Company::factory(),
            'currency_code' => 'USD',
            'exchange_rate_to_pkr' => 200.0,
            'pkr_amount' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
