<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutGoingDeliveryNoteOutgoing extends Model
{
    use HasFactory;

    protected $table = 'outgoing_delivery_note_outgoing';

    protected $fillable = [
        'customer_name',
        'customer_tax_number',
        'gib_dispatch_type',
        'gib_dispatch_send_type',
        'supplier_code',
        'dispatch_date',
        'dispatch_id',
        'amount',
        'status',
        'dispatch_uuid',
        'gib_post_box_email',
        'wild_card1',
        'erp_reference',
        'order_number',
        'activity_envelope',
        'package_info',
        'send_date',
        'received_date',
        'response_date',
        'mail_delivery_status',
        'portal_status',
        'last_update_user',
        'company_id',
        'user_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
