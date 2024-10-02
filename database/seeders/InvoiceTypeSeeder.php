<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Sales, Return, HKS Sales, With Holding, Exception, Special Base, Export Registration, Textbook, Broker, CHARGE, SURGERY, Accommodation Tax, HKS Broker
        $types=[
            ['name'=>'Sales'],
            ['name'=>'Return'],
            ['name'=>'HKS Sales'],
            ['name'=>'With Holding'],
            ['name'=>'Exception'],
            ['name'=>'Special Base'],
            ['name'=>'Export Registration'],
            ['name'=>'Textbook'],
            ['name'=>'Broker'],
            ['name'=>'CHARGE'],
            ['name'=>'SURGERY'],
            ['name'=>'Accommodation Tax'],
            ['name'=>'HKS Broker'],
        ];
        foreach ($types as $type){
            \App\Models\InvoiceType::create($type);
        }
    }
}
