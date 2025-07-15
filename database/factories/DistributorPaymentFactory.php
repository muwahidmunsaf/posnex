<?php

namespace Database\Factories;

use App\Models\Distributor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DistributorPayment>
 */
class DistributorPaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'distributor_id' => Distributor::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'type' => $this->faker->randomElement(['payment', 'commission', 'adjustment']),
            'description' => $this->faker->optional()->sentence(),
            'payment_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'reference_no' => $this->faker->optional()->uuid(),
        ];
    }
} 