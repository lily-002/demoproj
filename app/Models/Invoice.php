<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
   
    protected $fillable = [
            'send_type',
            'invoice_uuid',
            'invoice_date',
            'invoice_time',
            'invoice_id',
            'invoice_type',
            'invoice_scenario',
            'invoice_currency',
            'exchange_rate',
            'wildcard_1',
            'your_tapdk_number',
            'charge_start_date',
            'charge_start_time',
            'charge_end_date',
            'charge_end_time',
            'plate_number',
            'vehicle_id',
            'esu_report_id',
            'esu_report_date',
            'esu_report_time',
            'order_number',
            'order_date',
            'dispatch_number',
            'dispatch_date',
            'dispatch_time',
            'mode_code',
            'tr_id_number',
            'name_declarer',
            'name',
            'surname',
            'nationality',
            'passport_number',
            'passport_date',
            'receiver_name',
            'tax_number',
            'gib_post_box',
            'receiver_tapdk_number',
            'tax_office',
            'country',
            'city',
            'address',
            'receiver_email',
            'receiver_web',
            'receiver_phone',
            'payment_date',
            'payment_means',
            'payment_channel_code',
            'payee_financial_account',
            'total_products',
            'total_discount',
            'total_increase',
            'zero_zero_one_five_vat',
            'total_taxes',
            'bottom_total_discount_rate',
            'notes'
    ];

    public function sendType()
    {
        return $this->belongsTo(InvoiceSendType::class, 'send_type');
    }

    public function type()
    {
        return $this->belongsTo(InvoiceType::class, 'invoice_type');
    }

    public function scenario()
    {
        return $this->belongsTo(InvoiceScenario::class, 'invoice_scenario');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'invoice_currency');
    }

    public function products()
    {
        return $this->hasMany(InvoiceProducts::class, 'invoice_id');
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function getSendTypeByEmailAndUuid($email, $uuid)
{
    return Invoice::where('receiver_email', $email)
                  ->where('invoice_uuid', $uuid)
                  ->value('send_type');
}


}
