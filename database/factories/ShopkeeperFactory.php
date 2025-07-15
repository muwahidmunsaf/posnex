<?php

namespace Database\Factories;

use App\Models\Shopkeeper;
use App\Models\Distributor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopkeeperFactory extends Factory
{
    protected $model = Shopkeeper::class;

    public function definition()
    {
        return [
            'distributor_id' => Distributor::factory(),
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'remaining_amount' => $this->faker->numberBetween(0, 10000),
        ];
    }
} 