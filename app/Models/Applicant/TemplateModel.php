<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class TemplateModel extends Model
{
    protected $table = 'template_final_step_register';

    protected $fillable = [
        'description',
        'applicant_id',
        'personal_info_id',
        'work_experience_id',
        'sample_work',
        'sample_work_url',
    ];

    public function personalInfo()
{
    return $this->belongsTo(PersonalModel::class, 'personal_info_id');
}

public function workBackground()
{
    return $this->belongsTo(ExperienceModel::class, 'work_experience_id');
}

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }
}
