<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'amount_paid' => $this->faker->randomFloat(2, 100, 1000),
            'amount_due' => $this->faker->randomFloat(2, 0, 500),
            'date' => $this->faker->date(),
            'note' => $this->faker->sentence(4),
        ];
    }
}
