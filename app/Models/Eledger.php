<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eledger extends Model
{
    use HasFactory;

    protected $table="eledgers";

    protected $fillable = [
        'account_name',
        'transaction_type_id',
        'amount',
        'currency_id',
        'transaction_date',
        'description',
        'reference_number',
        'category_id',
        'attachment_url',
        'tax_info_id',
        'tax_amount',
        'payment_method_id',
        'payer_name',
        'payer_id_number',
        'status_id',
        'created_by',
        'updated_by',
        'user_id',
        'company_id',
    ];

    public function transactionType()
    {
        return $this->belongsTo(EledgerTransactionType::class, 'transaction_type_id');
    }

    public function category()
    {
        return $this->belongsTo(EledgerCategory::class, 'category_id');
    }

    public function taxInfo()
    {
        return $this->belongsTo(EledgerTaxInfo::class, 'tax_info_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethods::class, 'payment_method_id');
    }

    public function status()
    {
        return $this->belongsTo(EledgerStatus::class, 'status_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
