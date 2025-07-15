<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'type' => 'wholesale',
            'cel_no' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'cnic' => null,
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'company_id' => \App\Models\Company::factory(),
        ];
    }
} 