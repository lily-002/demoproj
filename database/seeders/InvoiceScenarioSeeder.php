<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceScenarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Basic, Commercial, Export, Accomplished Invoice, Exclusive, Government, HKS, ENEGERY
        $scenarios=[
            ['name'=>'Basic'],
            ['name'=>'Commercial'],
            ['name'=>'Export'],
            ['name'=>'Accomplished Invoice'],
            ['name'=>'Exclusive'],
            ['name'=>'Government'],
            ['name'=>'HKS'],
            ['name'=>'ENEGERY'],
        ];
        foreach ($scenarios as $scenario){
            \App\Models\InvoiceScenario::create($scenario);
        }
    }
}
