<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNoteSubmissionType extends Model
{
    use HasFactory;

    protected $table = 'edelivery_note_submission_type';

    protected $fillable = [
        'name'
    ];
}
