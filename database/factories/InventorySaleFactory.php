<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\Sale;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventorySale>
 */
class InventorySaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 100);
        $amount = $this->faker->randomFloat(2, 10, 1000);
        
        return [
            'sale_id' => Sale::factory(),
            'item_id' => Inventory::factory(),
            'quantity' => $quantity,
            'sale_type' => $this->faker->randomElement(['retail', 'wholesale']),
            'amount' => $amount,
            'total_amount' => $quantity * $amount,
            'company_id' => Company::factory(),
        ];
    }
} 