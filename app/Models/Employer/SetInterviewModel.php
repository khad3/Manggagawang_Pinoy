<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;

class SetInterviewModel extends Model
{
    protected $table = 'schedule_interview_by_employer';

    protected $fillable = [
        'employer_id',
        'job_id',
        'applicant_id',
        'date',
        'time',
        'preferred_location',
        'preferred_screening_method',
        'additional_notes'
    ];

    public function employer() {
        return $this->belongsTo(AccountInformationModel::class, 'employer_id');
    }
}
