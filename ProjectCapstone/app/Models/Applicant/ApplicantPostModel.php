<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class ApplicantPostModel extends Model
{
    protected $table = 'applicant_posts';


    protected $fillable = [
        'applicant_id',
        'personal_info_id',
        'work_experience_id',
        'content',
        'image_path',
    ];

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }

    public function personalInfo()
    {
        return $this->belongsTo(PersonalModel::class, 'personal_info_id');
    }

    public function workBackground()
    {
        return $this->belongsTo(ExperienceModel::class, 'work_experience_id');
    }
}
