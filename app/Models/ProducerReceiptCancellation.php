<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProducerReceiptCancellation extends Model
{
    use HasFactory;

    protected $table = 'producer_receipt_cancellations';

    protected $fillable = [
        'customer_name',
        'customer_tax_number',
        'producer_receipt_date',
        'producer_receipt_no',
        'ettn',
        'amount',
        'status',
        'gib_post_box_email',
        'mail_delivery_status',
        'portal_status',
        'connector_status',
        'cancellation_time',
        'last_update_user',
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
