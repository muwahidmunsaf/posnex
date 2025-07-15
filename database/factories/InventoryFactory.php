<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'item_name' => $this->faker->word(),
            'retail_amount' => $this->faker->randomFloat(2, 10, 100),
            'wholesale_amount' => $this->faker->randomFloat(2, 5, 90),
            'details' => $this->faker->sentence(6),
            'unit' => $this->faker->randomElement(['pcs', 'kg', 'ltr']),
            'barcode' => $this->faker->ean13(),
            'sku' => $this->faker->unique()->bothify('SKU-####'),
            'supplier_id' => Supplier::factory(),
            'category_id' => Category::factory(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'image' => null,
            'company_id' => Company::factory(),
        ];
    }
}
