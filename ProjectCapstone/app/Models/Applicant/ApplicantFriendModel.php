<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class ApplicantFriendModel extends Model
{
    protected $table = 'applicant_to_applicant_friend_list';

    protected $fillable = [
        'request_id',
        'receiver_id',
        'status',
    ];

    public function sender()
    {
        return $this->belongsTo(RegisterModel::class, 'request_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(RegisterModel::class, 'receiver_id', 'id');
    }

    public function personal_info()
    {
        return $this->belongsTo(PersonalModel::class, 'receiver_id', 'id');
    }

    public function workexperience()
    {
        return $this->belongsTo(ExperienceModel::class, 'receiver_id', 'id');
    }

    
}
