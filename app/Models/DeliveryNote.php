<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{
    use HasFactory;

     protected $table = 'edelivery_note_table';


    protected $fillable = [
        'invoice_uuid',
        'submission_type_id',
        'despatch_date',
        'despatch_id',
        'despatch_type_id',
        'invoice_scenario_id',
        'currency_unit_id',
        'carrier_title',
        'carrier_tin',
        'vehicle_plate_number',
        'total_amount',
        'wild_card1',
        'receiver_name',
        'receiver_tax_number',
        'receiver_gib_postacute',
        'receiver_tax_office',
        'receiver_country',
        'receiver_city',
        'receiver_destrict',
        'receiver_address',
        'receiver_mobile_number',
        'real_buyer',
        'buyer_tax_number',
        'buyer_tax_admin',
        'buyer_tax_office',
        'buyer_country',
        'buyer_city',
        'buyer_destrict',
        'buyer_address',
        'real_seller',
        'seller_tax_number',
        'seller_tax_admin',
        'seller_tax_office',
        'seller_country',
        'seller_city',
        'seller_destrict',
        'seller_address',
        'order_number',
        'order_date',
        'shipment_time',
        'additional_document_id',
        'second_receiver_country',
        'second_receiver_ill',
        'second_receiver_postal_code',
        'second_receiver_district',
        'second_receiver_address',
        'notes',
    ];

    public function submissionType()
    {
        return $this->belongsTo(DeliveryNoteSubmissionType::class, 'submisson_type_id');
    }

    public function despatchType()
    {
        return $this->belongsTo(DeliveryNoteDespatchType::class, 'despatch_type_id');
    }

    public function invoiceScenario()
    {
        return $this->belongsTo(DeliveryNoteInvoiceScenario::class, 'invoice_scenario_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_unit_id');
    }

    public function products()
    {
        return $this->hasMany(DeliveryNoteProduct::class, 'edelivery_note_id');
    }

    public function drivers()
    {
        return $this->hasMany(DeliveryNoteDriverInfo::class, 'edelivery_note_id');
        
    }

    public function trailers()
    {
        return $this->hasMany(DeliveryNoteTrailerInfo::class, 'edelivery_note_id');
        
    }

     public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
