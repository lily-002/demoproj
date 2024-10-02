<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryNoteInvoiceScenarioeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scenarios = [
            ['name' => 'Basic'],
  
        ];

        foreach ($scenarios as $scenario) {
            \App\Models\DeliveryNoteInvoiceScenario::create($scenario);
        }
    }
}
