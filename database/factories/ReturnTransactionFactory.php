<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReturnTransaction>
 */
class ReturnTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sale_id' => Sale::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'company_id' => Company::factory(),
        ];
    }
}
