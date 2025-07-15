<?php

namespace Database\Factories;

use App\Models\PurchaseItem;
use App\Models\Purchase;
use App\Models\Inventory;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseItemFactory extends Factory
{
    protected $model = PurchaseItem::class;

    public function definition()
    {
        return [
            'purchase_id' => Purchase::factory(),
            'inventory_id' => Inventory::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'purchase_amount' => $this->faker->randomFloat(2, 10, 1000),
            'company_id' => Company::factory(),
        ];
    }
} 