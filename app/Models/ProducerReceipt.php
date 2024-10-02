<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProducerReceipt extends Model
{
    use HasFactory;

    protected $table = "producer_receipts";
    protected $dates = ['producer_date'];

    protected $fillable = [
        'producer_uuid',
        'producer_date',
        'producer_name',
        'unit_id',
        'total_amount',
        'title',
        'receiver_name',
        'receiver_tax_number',
        'receiver_tax_office',
        'sms_notification_for_earchive',
        'add_to_address_book',
        'buyer_country',
        'buyer_city',
        'buyer_email',
        'buyer_mobile_number',
        'buyer_web_address',
        'buyer_address',
        'total_product_services',
        'total_0003_stoppage',
        'total_taxes',
        'total_payable',
        'notes',
        'company_id',
        'user_id',
    ];

    public function company()
    {
        return $this->belongsTo(
            Company::class,
            'company_id',
            'id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function products()
    {
        return $this->hasMany(
            ProducerReceiptProduct::class,
            'producer_receipt_id',
            'id'
        );
    }

    public function unit()
    {
        return $this->belongsTo(
            Unit::class,
            'unit_id',
            'id'
        );
    }
}