<?php

namespace App\Models\Notification;

use App\Models\Applicant\RegisterModel;
use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications_sa_lahat';

    protected $fillable = [
        'type',
        'type_id',
        'title',
        'message',
        'is_read',
        'link',
    ];

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'type_id', 'id');
    }

    public function employer()
    {
        return $this->belongsTo(\App\Models\Employer\AccountInformationModel::class, 'type_id', 'id');
    }


}
