<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;
use App\Models\Applicant\RegisterModel as RegisterApplicants;

class PersonalModel extends Model
{
    protected $table = 'personal_info';

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'house_street',
        'city',
        'province',
        'zipcode',
        'barangay',
        'applicant_id',
    ];

    public function applicant()
{
    return $this->belongsTo(RegisterApplicants::class, 'applicant_id');
}

public function work()
{
    return $this->belongsTo(ExperienceModel::class, 'work_experience_id');
}
   


}