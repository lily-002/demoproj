<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProducerReceiptOutgoing extends Model
{
    use HasFactory;
    
    protected $table = 'producer_receipt_outgoings';

    protected $fillable = [
        'customer_name',
        'customer_tax_number',
        'producer_receipt_date',
        'mm_no',
        'amount',
        'status',
        'ettn',
        'gib_post_box_email',
        'mail_delivery_status',
        'portal_status',
        'connector_status',
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
