<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

     protected $fillable = [
        "name",
     ];

     public function productSubCategory(){
        return  $this->hasOne(ProductSubCategory::class, 'product_category_id');
     }

     public function productSubCategories(){
        return $this->hasMany(ProductSubCategory::class);
     }
    
}
