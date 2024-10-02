<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvoiceDecreaseIncrease;

class InvoiceProducts extends Model
{
    use HasFactory;

    protected $table = 'invoice_products';


    protected $fillable = [
        'product_service',
        'quantity',
        'unit_measurement',
        'price',
        'taxable_amount',
        'zero_zero_one_five_vat_rate',
        'zero_zero_one_five_vat_amount',
        'taxline_total',
        'payabl_line_total',
        'invoice_id',
        'product_category_id',
        'product_subcategory_id'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    function decreaseIncrease()
    {
        return $this->hasMany(InvoiceDecreaseIncrease::class, 'invoice_product_id');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');        
    }

    public function productSubCategory()
    {
        return $this->belongsTo(
            ProductSubCategory::class, 
            'product_subcategory_id'
        );        
    }
}
