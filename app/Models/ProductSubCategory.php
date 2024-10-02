<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    use HasFactory;

    protected $table = "product_subcategories";

    protected $fillable = [
        "name",
     ];

     public function productCategory(){
        return $this->belongsTo(ProductCategory::class,'product_category_id');
     }

}
