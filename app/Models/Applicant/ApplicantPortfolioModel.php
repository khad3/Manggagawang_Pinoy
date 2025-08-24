<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class ApplicantPortfolioModel extends Model
{
    protected $table = 'applicants_portfolio';

    protected $fillable = [
        'applicant_id',
        'personal_info_id',
        'template_final_step_register_id',
        'work_experience_id',
        'sample_work_image',
        'sample_work_title',
        'sample_work_description',
       
    ];

    public function personalInfo()
    {
        return $this->belongsTo(PersonalModel::class, 'personal_info_id');
    }

    public function workExperience()
    {
        return $this->belongsTo(ExperienceModel::class, 'work_experience_id');
    }

    public function templateFinalStepRegister()
    {
        return $this->belongsTo(TemplateModel::class, 'template_final_step_register_id');
    }

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }
}
