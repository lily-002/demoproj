<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNoteTrailerInfo extends Model
{
    use HasFactory;

    protected $table = 'edelivery_note_trailer_info';

    protected $fillable = [
        'plate_number',
        'edelivery_note_id'
    ];

    public function edelivery_note()
    {
        return $this->belongsTo(DeliveryNote::class, "edelivery_note_id");
    }
}
