<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            ['name' => 'Cash'],
            ['name' => 'Bank Transfer'],
            ['name' => 'Cheque'],
            ['name' => 'Credit Card'],
            ['name' => 'Debit Card'],
            ['name' => 'Mobile Money'],
        ];

        foreach ($paymentMethods as $paymentMethod) {
            \App\Models\PaymentMethods::create($paymentMethod);
        }

    }
}
