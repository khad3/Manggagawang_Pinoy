<?php

namespace App\Models\Applicant;

use App;
use Illuminate\Database\Eloquent\Model;

class SavedJobModel extends Model
{
    protected $table = 'saved_job_table';

    protected $fillable = [
        'job_id',
        'applicant_id',
    ];

    public function job()
    {
        return $this->belongsTo(App\Models\Employer\JobDetailModel::class, 'job_id');
    }

    public function company()
    {
        return $this->hasOne(App\Models\Employer\CompanyAdressModel::class, 'job_id');
    }

    public function personal_info()
    {
        return $this->hasOne(App\Models\Employer\PersonalInformationModel::class, 'job_id');
    }
}
