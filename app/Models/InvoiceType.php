<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceType extends Model
{
    use HasFactory;

    protected $table = 'invoice_types';

    protected $fillable = [
        'name',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
