<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryNoteDespatchTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Despatching'],
        ];

        foreach ($types as $type) {
            \App\Models\DeliveryNoteDespatchType::create($type);
        }
    }
}
