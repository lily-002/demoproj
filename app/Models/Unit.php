<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'measurement_units';

     public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
