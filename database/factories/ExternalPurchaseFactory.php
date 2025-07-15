<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExternalPurchase>
 */
class ExternalPurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purchaseE_id' => $this->faker->unique()->numerify('N001-#####'),
            'item_name' => $this->faker->words(3, true),
            'details' => $this->faker->optional()->sentence(),
            'purchase_amount' => $this->faker->randomFloat(2, 10, 10000),
            'purchase_source' => $this->faker->optional()->company(),
            'created_by' => $this->faker->name(),
            'company_id' => Company::factory(),
        ];
    }
} 