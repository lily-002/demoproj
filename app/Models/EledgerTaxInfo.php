<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EledgerTaxInfo extends Model
{
    use HasFactory;

    protected $table = 'eledger_tax_infos';

    protected $fillable = [
        'name',
    ];
}
