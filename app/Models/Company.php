<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'tax_number',
        'tax_office',
        'mersis_number',
        'business_registry_number',
        'operating_center',
        'country',
        'city',
        'address',
        'email',
        'phone_number',
        'website',
        'gib_registration_data',
        'gib_sender_alias',
        'gib_receiver_alias',
        'e-signature_method',
        'date_of_last_update',
        'last_update_user',
        // 'user_id',
    ];

    // protected $hidden = [
    //     'user_id',
    // ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function einvoice()
    {
        return $this->hasMany(EInvoice::class, 'company_id');
    }

    public function outgoingDeliveryNote()
    {
        return $this->hasMany(OutGoingDeliveryNote::class, 'company_id');
    }

    /**
     * Define a relationship to retrieve the incoming delivery notes associated with this company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incomingDeliveryNotes()
    {
        return $this->hasMany(
            InComingDeliveryNote::class,
            'company_id'
        );
    }

    /**
     * Define a relationship to retrieve the outgoing producer receipt associated with this company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outgoingProducerReceipts()
    {
        return $this->hasMany(
            OutgoingProducerReceipt::class,
            'company_id'
        );
    }
}
