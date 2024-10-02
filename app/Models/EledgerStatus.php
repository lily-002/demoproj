<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EledgerStatus extends Model
{
    use HasFactory;

    protected $table = 'eledger_statuses';

    protected $fillable = [
        'name',
    ];
}
