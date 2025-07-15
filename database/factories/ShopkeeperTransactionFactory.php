<?php

namespace Database\Factories;

use App\Models\ShopkeeperTransaction;
use App\Models\Shopkeeper;
use App\Models\Distributor;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopkeeperTransactionFactory extends Factory
{
    protected $model = ShopkeeperTransaction::class;

    public function definition()
    {
        return [
            'shopkeeper_id' => Shopkeeper::factory(),
            'distributor_id' => Distributor::factory(),
            'inventory_id' => Inventory::factory(),
            'type' => $this->faker->randomElement(['product_received', 'product_sold', 'product_returned', 'payment_made']),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 10, 1000),
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
            'commission_amount' => $this->faker->randomFloat(2, 10, 500),
            'transaction_date' => $this->faker->date(),
            'description' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
        ];
    }
} 