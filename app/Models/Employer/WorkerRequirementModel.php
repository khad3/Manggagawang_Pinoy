<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;

class WorkerRequirementModel extends Model
{
    
    protected $table = 'worker_requirements';

    protected $fillable = [

        'employer_id',
        'personal_info_id',
        'number_of_workers',
        'project_duration',
        'skill_requirements',
    ];

    public function employer()
    {
        return $this->belongsTo(AccountInformationModel::class, 'employer_id');
    }

    public function personal_info()
    {
        return $this->belongsTo(PersonalInformationModel::class, 'personal_info_id');
    }

}
