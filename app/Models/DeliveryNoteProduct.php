<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNoteProduct extends Model
{
    use HasFactory;

    protected $table = 'edelivery_note_products';


    protected $fillable = [
        'product_service',
        'quantity_one',
        'unit_id_one',
        'quantity_two',
        'unit_id_two',
        'price',
        'product_amount',
        'edelivery_note_id',
        'product_category_id',
        'product_subcategory_id'
    ];

    public function edelivery_note()
    {
        return $this->belongsTo(DeliveryNote::class,"edelivery_note_id");
    }

    public function unit_one()
    {
        return $this->belongsTo(Unit::class, 'unit_id_one');
    }

    public function unit_two()
    {
        return $this->belongsTo(Unit::class, 'unit_id_two');
    }
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');        
    }
}
