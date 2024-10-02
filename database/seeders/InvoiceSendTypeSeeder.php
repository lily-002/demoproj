<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSendTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sendTypes = [
            ['name' => 'e-Invoice'],
            ['name' => 'e-Archive'],
          
      
        ];

        foreach ($sendTypes as $sendType) {
            \App\Models\InvoiceSendType::create($sendType);
        }
    }
}
