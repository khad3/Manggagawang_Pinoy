<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;

class SendNotificationToApplicantModel extends Model
{
    protected $table = 'notification_for_applicant_interview';

    protected $fillable = [
        'receiver_id',
        'sender_id',
        'title',
        'type',
        'message',
        'is_read',
    ];
}
