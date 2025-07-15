<?php

namespace Database\Factories;

use App\Models\DistributorProduct;
use App\Models\Distributor;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class DistributorProductFactory extends Factory
{
    protected $model = DistributorProduct::class;

    public function definition()
    {
        return [
            'distributor_id' => Distributor::factory(),
            'inventory_id' => Inventory::factory(),
            'quantity_assigned' => $this->faker->numberBetween(1, 100),
            'quantity_remaining' => $this->faker->numberBetween(0, 100),
            'unit_price' => $this->faker->randomFloat(2, 10, 1000),
            'total_value' => $this->faker->randomFloat(2, 100, 10000),
            'assignment_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['active', 'completed', 'cancelled']),
            'notes' => $this->faker->optional()->sentence(),
            'assignment_number' => $this->faker->unique()->numerify('ASSIGN###'),
        ];
    }
} 