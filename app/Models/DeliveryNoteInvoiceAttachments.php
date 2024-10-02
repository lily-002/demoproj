<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNoteInvoiceAttachments extends Model
{
    use HasFactory;

    protected $table = 'edelivery_note_invoice_attachments';

    protected $fillable = [
        'file_url',
        'edelivery_note_id'
    ];

    public function edelivery_note()
    {
        return $this->belongsTo(DeliveryNote::class);
    }
}
