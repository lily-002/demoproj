<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNoteInvoiceScenario extends Model
{
    use HasFactory;

    protected $table = 'edelivery_note_invoice_scenario';

    protected $fillable = [
        'name'
    ];
}
