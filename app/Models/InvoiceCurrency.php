<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceCurrency extends Model
{
    use HasFactory;

    protected $table = 'invoice_currencies';

    protected $fillable = [
        'name',
        'code',
    ];

     public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
