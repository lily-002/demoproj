<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = ['E-Invoice', 'E-Invoice Archived', 'E-Delivery Notes', 'E-Producer'];
        foreach ($products as $product) {
           Product::create([
                'name' => $product,
                'description' => $product,
            ]);
        }
    }
}
