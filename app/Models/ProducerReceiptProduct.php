<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProducerReceiptProduct extends Model
{
    use HasFactory;
    
    protected $table = "producer_receipt_products";

    protected $fillable = [
        'fee_reason',
        'quantity1',
        'quantity2',
        'unit_id1',
        'unit_id2',
        'price',
        'gross_amount',
        'rate',
        'amount',
        'tax_line_total',
        'payable_line',
        'producer_receipt_id',
        'product_category_id',
        'product_subcategory_id',
    ];

    public function producer_receipt()
    {
        $this->belongsTo(
            ProducerReceipt::class,
            'producer_receipt_id',
            'id'
        );
    }

    public function unit1()
    {
        $this->belongsTo(
            Unit::class,
            'unit_id1',
            'id'
        );
    }

    public function unit2()
    {
        $this->belongsTo(
            Unit::class,
            'unit_id2',
            'id'
        );
    }
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');        
    }
}
