<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingDeliveryNoteIncoming extends Model
{
    use HasFactory;

    protected $table = 'incoming_delivery_notes_incoming';

    protected $fillable = [
        'customer_name',
        'customer_tax_number',
        'gib_dispatch_type',
        'supplier_code',
        'dispatch_date',
        'dispatch_id',
        'amount',
        'status',
        'dispatch_uuid',
        'wild_card1',
        'erp_reference',
        'order_number',
        'activity_envelope',
        'package_info',
        'recieved_date',
        'response_date',
        'mail_delivery_status',
        'portal_status',
        'connector_status',
        'last_update_user',
        'is_active',
        'is_archive',
        'company_id',
        'user_id'
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
