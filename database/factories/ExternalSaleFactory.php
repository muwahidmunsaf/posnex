<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Customer;
use App\Models\ExternalPurchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExternalSale>
 */
class ExternalSaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sale_amount = $this->faker->randomFloat(2, 10, 10000);
        $tax_amount = $sale_amount * 0.1; // 10% tax
        $total_amount = $sale_amount + $tax_amount;
        
        return [
            'saleE_id' => $this->faker->unique()->numerify('S001-#####'),
            'purchaseE_id' => ExternalPurchase::factory(),
            'sale_amount' => $sale_amount,
            'payment_method' => $this->faker->randomElement(['cash', 'card', 'online']),
            'tax_amount' => $tax_amount,
            'total_amount' => $total_amount,
            'created_by' => $this->faker->name(),
            'company_id' => Company::factory(),
            'customer_id' => Customer::factory(),
        ];
    }
} 