<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProducerReceipt>
 */
class ProducerReceiptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unitIds = Unit::pluck('id')->toArray();
        $companyId = Company::pluck('id');
        $userId = User::pluck('id');

        return [
            'producer_uuid' => fake()->uuid(),
            'producer_date' => fake()->date(),
            'producer_name' => fake()->company(),
            'unit_id' => fake()->randomElement($unitIds), 
            'total_amount' => fake()->randomFloat(2, 1000, 100000),
            'title' => fake()->jobTitle(),
            'receiver_name' => fake()->name(),
            'receiver_tax_number' => fake()->regexify('[A-Z0-9]{10}'),
            'receiver_tax_office' => fake()->city(),
            'buyer_country' => fake()->country(),
            'buyer_city' => fake()->city(),
            'buyer_email' => fake()->email(),
            'buyer_mobile_number' => fake()->phoneNumber(),
            'buyer_web_address' => fake()->url(),
            'buyer_address' => fake()->address(),
            'total_product_services' => fake()->randomFloat(2, 1000, 10000),
            'total_0003_stoppage' => fake()->randomFloat(2, 1000, 10000),
            'total_taxes' => fake()->randomFloat(2, 1000, 10000),
            'total_payable' => fake()->randomFloat(2, 1000, 10000),
            'notes' => fake()->text(400),
            'company_id' => $companyId, 
            'user_id' => $userId, 
        ];
    }
}