<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;

class InterviewScreeningModel extends Model
{
    
    protected $table = 'worker_interview_preference';

    protected $fillable = [

        'employer_id',
        'personal_info_id',
        'preferred_screening_method',
        'preferred_interview_location',


    ];

    public function employer()
    {
        return $this->belongsTo(AccountInformationModel::class);
    }

    public function personal_info()
    {
        return $this->belongsTo(PersonalInformationModel::class, 'personal_info_id');
    }

}
