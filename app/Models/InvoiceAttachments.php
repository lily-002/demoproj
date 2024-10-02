<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceAttachments extends Model
{
    use HasFactory;

    protected $table = 'invoice_attachments';

    protected $fillable = [
        'name',
        'path',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
