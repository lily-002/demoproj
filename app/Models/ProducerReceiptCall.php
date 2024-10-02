<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProducerReceiptCall extends Model
{
    use HasFactory;

    protected $table = 'producer_receipt_calls';

    protected $fillable = [
        'sender_company',
        'sender_company_vkn',
        'sender_company_mailbox',
        'customer_name',
        'customer_tax_number',
        'mm_tarihi',
        'mm_no',
        'ettn',
        'amount',
        'status',
        'gib_post_box_email',
        'portal_status',
        'connector_status',
        'cancell_status',
        'is_archive',
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
