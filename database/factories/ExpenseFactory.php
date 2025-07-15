<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purpose' => $this->faker->sentence(3),
            'details' => $this->faker->sentence(6),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'paidBy' => $this->faker->name(),
            'paymentWay' => $this->faker->randomElement(['cash', 'card', 'online']),
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
