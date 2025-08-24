<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class ApplicantUrlModel extends Model
{
    protected $table = 'applicants_sample_work_url';

    protected $fillable = [
        'sample_work_title',
        'sample_work_url',
        'personal_info_id',
        'work_experience_id',
        'applicant_id',
    ];

    public function personalInfo()
    {
        return $this->belongsTo(PersonalModel::class, 'personal_info_id');
    }

    public function workExperience()
    {
        return $this->belongsTo(ExperienceModel::class, 'work_experience_id');
    }

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }
}
