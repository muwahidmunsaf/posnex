<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sale_code' => $this->faker->unique()->bothify('S###'),
            'created_by' => $this->faker->name(),
            'subtotal' => $this->faker->randomFloat(2, 100, 1000),
            'total_amount' => $this->faker->randomFloat(2, 100, 1200),
            'tax_percentage' => $this->faker->randomFloat(2, 0, 20),
            'tax_amount' => $this->faker->randomFloat(2, 0, 200),
            'payment_method' => $this->faker->randomElement(['Cash', 'Card', 'Online']),
            'discount' => $this->faker->randomFloat(2, 0, 100),
            'company_id' => Company::factory(),
            'customer_id' => Customer::factory(),
            'customer_name' => $this->faker->name(),
            'sale_type' => $this->faker->randomElement(['retail', 'wholesale']),
            'amount_received' => $this->faker->randomFloat(2, 100, 1200),
            'change_return' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
