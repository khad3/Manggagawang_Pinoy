<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class ParticipantModel extends Model
{
    protected $table = 'group_participants';

    protected $fillable = [
        'group_community_id',
        'applicant_id',
        'status',
        'personal_info_id',
    ];

    public function group()
    {
        return $this->belongsTo(GroupModel::class, 'group_community_id');
    }

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }

    public function personalInfo()
    {
        return $this->belongsTo(PersonalModel::class, 'personal_info_id');
    }
}
