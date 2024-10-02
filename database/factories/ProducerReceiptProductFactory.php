<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProducerReceiptProduct>
 */
class ProducerReceiptProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unitIds = Unit::pluck('id')->toArray();

        return [
            'fee_reason' => fake()->sentence(10),
            'quantity1' => fake()->numberBetween(1, 5),
            'quantity2' => fake()->numberBetween(1, 5),
            'unit_id1' => fake()->randomElement($unitIds), 
            'unit_id2' => fake()->randomElement($unitIds), 
            'price' => fake()->randomFloat(2, 1000, 10000),
            'gross_amount' => fake()->randomFloat(2, 10000, 50000),
            'rate' => fake()->randomFloat(2, 1, 100),
            'amount' => fake()->randomFloat(2, 1000, 100000),
            'tax_line_total' => fake()->randomFloat(2, 1000, 10000),
            'payable_line' => fake()->randomFloat(2, 1000, 100000),
        ];
    }
}
