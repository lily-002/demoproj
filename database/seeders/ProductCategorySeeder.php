<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics (e.g., smartphones, laptops, tablets)', 'vat' => 20],
            ['name' => 'Clothing and Apparels', 'vat' => 10],
            [
                'name' => 'Food and Beverages',
                'vat' => null,
                'subcategories' => [
                    ['name' => 'Basic food items (e.g., bread, milk)', 'vat' => 1],
                    ['name' => 'Processed foods and beverages', 'vat' => 1],
                ]
            ],
            ['name' => 'Furniture (e.g., chairs, tables, cabinets)', 'vat' => 10],
            ['name' => 'Books and Educational Materials', 'vat' => 0],
            [
                'name' => 'Medical Products (e.g., pharmaceuticals, medical devices)',
                'subcategories' => [
                    ['name' => 'Pharmaceuticals', 'vat' => 10],
                    ['name' => 'Medical devices', 'vat' => 10],
                ]
            ],
            ['name' => 'Automotive (e.g., cars, motorcycles, parts)', 'vat' => 20],
           
        ];

        foreach ($categories as $categoryData) {
            if (isset($categoryData['subcategories'])) {
                $subcategories = $categoryData['subcategories'];
                unset($categoryData['subcategories']);
                $category = ProductCategory::create($categoryData);

                foreach ($subcategories as $subcategoryData) {
                    $subcategoryData['product_category_id'] = $category->id;
                    ProductSubCategory::create($subcategoryData);
                }
            } else {
                ProductCategory::create($categoryData);
            }
        }
    }
}
