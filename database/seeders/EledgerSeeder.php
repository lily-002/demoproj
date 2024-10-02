<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EledgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactionTypes = [
            ['name' => 'Debit'],
            ['name' => 'Credit'],
        ];

        foreach ($transactionTypes as $transactionType) {
            \App\Models\EledgerTransactionType::create($transactionType);
        }

        $taxInfos = [
            ['name' => 'VAT'],
            ['name' => 'GSR'],
        ];

        foreach ($taxInfos as $taxInfo) {
            \App\Models\EledgerTaxInfo::create($taxInfo);
        }

        $categories = [
            ['name' => 'Sales'],
            ['name' => 'Purchases'],
            ['name' => 'Expenses'],
        ];

        foreach ($categories as $category) {
            \App\Models\EledgerCategory::create($category);
        }

        $statuses = [
            ['name' => 'Pending'],
            ['name' => 'Completed'],
            ['name' => 'Cancelled'],
        ];

        foreach ($statuses as $status) {
            \App\Models\EledgerStatus::create($status);
        }

        // $paymentMethods = [
        //     ['name' => 'Cash'],
        //     ['name' => 'Bank Transfer'],
        //     ['name' => 'Cheque'],
        //     ['name' => 'Credit Card'],
        //     ['name' => 'Debit Card'],
        //     ['name' => 'Mobile Money'],
        // ];

        // foreach ($paymentMethods as $paymentMethod) {
        //     \App\Models\EledgerPaymentMethod::create($paymentMethod);
        // }
    }
}
