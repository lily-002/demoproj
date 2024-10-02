<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNoteDriverInfo extends Model
{
    use HasFactory;

    protected $table = 'edelivery_note_driver_info';

    protected $fillable = [
        'name',
        'surname',
        'tckn',
        'edelivery_note_id'
    ];

    public function edelivery_note()
    {
        return $this->belongsTo(DeliveryNote::class, "edelivery_note_id");
    }

}
