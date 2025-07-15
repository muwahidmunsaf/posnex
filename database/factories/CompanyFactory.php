<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'type' => $this->faker->randomElement(['wholesale', 'retail', 'both']),
            'cell_no' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->companyEmail(),
            'ntn' => $this->faker->numerify('#####-#######'),
            'tel_no' => $this->faker->phoneNumber(),
            'taxCash' => $this->faker->randomFloat(2, 0, 20),
            'taxCard' => $this->faker->randomFloat(2, 0, 20),
            'taxOnline' => $this->faker->randomFloat(2, 0, 20),
            'website' => $this->faker->url(),
            'address' => $this->faker->address(),
            'logo' => null,
        ];
    }
}
