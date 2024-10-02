<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EledgerCategory extends Model
{
    use HasFactory;

    protected $table = 'eledger_categories';

    protected $fillable = [
        'name',
    ];
}
