<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'position' => $this->faker->jobTitle(),
            'salary' => $this->faker->randomFloat(2, 20000, 100000),
            'contact' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
