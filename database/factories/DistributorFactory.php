<?php

namespace Database\Factories;

use App\Models\Distributor;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class DistributorFactory extends Factory
{
    protected $model = Distributor::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'commission_rate' => $this->faker->randomElement([5, 10, 15]),
            'company_id' => Company::factory(),
        ];
    }
} 