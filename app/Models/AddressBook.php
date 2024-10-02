<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    use HasFactory;

    protected $table = "address_book";

    protected $fillable = [
        "supplier_name",
        "supplier_code",
        "tax_office",
        "tax_number",
        "payment_method_id",
        "payment_channel",
        "payment_account_number",
        "country",
        "city",
        "county",
        "post_code",
        "phone_number",
        "address",
        "mobile_phone_notification",
        "outgoing_einvoice_sms_notification",
        "sent_sms_earchive_invoice",
        "sent_email_earchive_invoice",
        "email",
        "web_url",
        "gib_registration_date",
        "gib_receiver_alias",
        "gib_mailbox_label"
    ];
}
