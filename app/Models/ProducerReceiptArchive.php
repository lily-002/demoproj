<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProducerReceiptArchive extends Model
{
    use HasFactory;

    protected $table = 'producer_receipt_archives';

    protected $fillable = [
        'customer_name',
        'customer_tax_number',
        'producer_receipt_date',
        'producer_receipt_no',
        'ettn',
        'amount',
        'status',
        'gib_post_box_email',
        'portal_status',
        'connector_status',
        'company_id',
        'user_id',
    ];

    public function company()
    {
        return $this->belongsTo(
            Company::class,
            'company_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
