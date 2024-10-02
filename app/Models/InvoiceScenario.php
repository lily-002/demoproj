<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceScenario extends Model
{
    use HasFactory;

    protected $table = 'invoice_scenarios';

    protected $fillable = [
        'name',
    ];

   public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
