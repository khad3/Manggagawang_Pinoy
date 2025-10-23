<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;
use App\Models\Applicant\ApplyJobModel;

class JobDetailModel extends Model
{
    protected $table = 'job_details_employer';

    protected $fillable = [
        'employer_id',
        'title',
        'department',
        'location',
        'work_type',
        'experience_level',
        'job_salary',
        'job_description',
        'additional_requirements',
        'tesda_certification',
        'other_certifications',
        'none_certifications',
        'none_certifications_qualification',
        'benefits',
        'other_department',
        'job_type'
    ];

    public function employer()
    {
        return $this->belongsTo(AccountInformationModel::class, 'employer_id');
    }

    public function interviewScreening()
    {
        return $this->belongsTo(InterviewScreeningModel::class, 'job_id');
    }

    public function workerRequirement()
    {
        return $this->belongsTo(WorkerRequirementModel::class, 'job_id');
    }

    public function personal_info()
    {
        return $this->belongsTo(PersonalInformationModel::class, 'job_id');
    }

    public function specialRequirement()
    {
        return $this->belongsTo(SpecialRequirementModel::class, 'job_id');
    }

    //new
    public function company(){
        return $this->belongsTo(CompanyAdressModel::class, 'job_id');
    }

    public function companyAddress(){
        return $this->belongsTo(CompanyAdressModel::class, 'employer_id' , 'employer_id');
    }

     //new
    public function companyName(){
        return $this->belongsTo(CompanyAdressModel::class, 'employer_id' , 'employer_id');
    }

    public function applications()
{
    return $this->hasMany(ApplyJobModel::class, 'job_id' , 'id');
}
    
public function appalicationsApproved()
{
    return $this->hasMany(ApplyJobModel::class, 'job_id', 'id')
                ->where('status', 'approved');
}
}
