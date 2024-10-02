<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNoteDespatchType extends Model
{
    use HasFactory;

    protected $table = 'edelivery_note_despatch_type';

    protected $fillable = [
        'name'
    ];
}
