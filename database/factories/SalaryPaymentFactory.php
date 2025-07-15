<?php

namespace Database\Factories;

use App\Models\SalaryPayment;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryPaymentFactory extends Factory
{
    protected $model = SalaryPayment::class;

    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'amount' => $this->faker->randomFloat(2, 1000, 10000),
            'date' => $this->faker->date(),
            'note' => $this->faker->optional()->sentence(),
        ];
    }
} 