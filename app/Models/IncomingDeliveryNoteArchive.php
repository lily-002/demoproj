<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingDeliveryNoteArchive extends Model
{
    use HasFactory;

    protected $table = 'incoming_delivery_notes_archive';

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
        'package_info',
        'portal_status',
        'connector_status',
        'last_update_user',
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
