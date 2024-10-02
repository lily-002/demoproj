<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryNoteSubmissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'e-Despatch'],
            ['name' => 'e-Archive'],
  
        ];

        foreach ($types as $type) {
            \App\Models\DeliveryNoteSubmissionType::create($type);
        }
        
    }
}
