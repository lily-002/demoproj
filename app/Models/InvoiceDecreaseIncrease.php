<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDecreaseIncrease extends Model
{
    use HasFactory;

    protected $table = 'invoice_decrease_increase';

    protected $fillable = [
        'type',
        'rate',
        'amount',
        'invoice_product_id',
    ];

    public function product()
    {
        return $this->belongsTo(InvoiceProducts::class);
    }
}
