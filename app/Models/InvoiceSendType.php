<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSendType extends Model
{
    use HasFactory;

    protected $table = 'invoice_send_types';

    protected $fillable = [
        'name',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
