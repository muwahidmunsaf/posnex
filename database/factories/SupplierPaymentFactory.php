<?php

namespace Database\Factories;

use App\Models\SupplierPayment;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierPaymentFactory extends Factory
{
    protected $model = SupplierPayment::class;

    public function definition()
    {
        return [
            'supplier_id' => Supplier::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'payment_date' => $this->faker->date(),
            'payment_method' => $this->faker->randomElement(['cash', 'bank', 'cheque']),
            'note' => $this->faker->optional()->sentence(),
            'currency_code' => $this->faker->currencyCode(),
            'exchange_rate_to_pkr' => $this->faker->randomFloat(2, 1, 300),
            'pkr_amount' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
} 