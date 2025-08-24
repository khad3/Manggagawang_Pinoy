<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class GroupModel extends Model
{
    protected $table = 'group_community';

    protected $fillable = [
        'group_name',
        'group_description',
        'privacy',
        'applicant_id',
        'personal_info_id',
    ];


    public function personalInfo()
    {
        return $this->belongsTo(PersonalModel::class, 'personal_info_id');
    }

    public function work_background()
    {
         return $this->belongsTo(ExperienceModel::class, 'work_experience_id');
    }
public function members()
{
    return $this->belongsToMany(RegisterModel::class, 'group_participants', 'group_community_id', 'applicant_id')
                ->withPivot('status')
                ->withTimestamps();
}



}
