<?php

namespace App\Models\Applicant;


use Illuminate\Database\Eloquent\Model;

use App\Models\Applicant\PersonalModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Admin\SuspensionModel;
use App\Models\Employer\SendMessageModel;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class RegisterModel extends Authenticatable
{
    use Notifiable;

    protected $table = 'applicants';

    protected $fillable = [
        'username',
        'email',
        'password',
        'verification_code',
        'email_verification_code_expires_at',
        'is_verified',
        'last_seen',
        'typing_indicator',
        'is_online',
        
    ];

     protected $hidden = [
        'password',
        'remember_token',
    ];

    public function personal_info()
{
    return $this->hasOne(PersonalModel::class, 'applicant_id');
}



public function work_background()
{
    return $this->hasOne(ExperienceModel::class, 'applicant_id');
}

public function template()
{
    return $this->hasOne(TemplateModel::class, 'applicant_id');
}

public function joinedGroups()
{
    return $this->belongsToMany(GroupModel::class, 'group_participants', 'applicant_id', 'group_community_id')
                ->withPivot('status')
                ->withTimestamps();
}


public function isOnline()
{
    return $this->last_seen && Carbon::parse($this->last_seen)->gt(now()->subMinutes(2));
}

public function appliedJobs()
{
    return $this->hasMany(ApplyJobModel::class, 'applicant_id');

}


public function suspension()
{
    return $this->hasOne(SuspensionModel::class, 'applicant_id');

}

public function messages()
{
    return $this->hasMany(SendMessageModel::class, 'applicant_id');
}


public function certifications()
{
    return $this->hasMany(TesdaUploadCertificationModel::class, 'applicant_id');
}

}