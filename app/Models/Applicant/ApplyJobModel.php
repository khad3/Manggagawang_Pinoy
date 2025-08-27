<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Models\Employer\JobDetailModel as JobDetails;
class ApplyJobModel extends Model
{
    protected $table = 'applying_job_to_employers';

    protected $fillable = [
        'job_id',
        'applicant_id',
        'cover_letter',
        'resume',
        'tesda_certification',
        'cellphone_number',
        'additional_information',
        'status',
    ];

    public function job()
    {
        return $this->belongsTo(JobDetails::class, 'job_id');
    }

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }
}
