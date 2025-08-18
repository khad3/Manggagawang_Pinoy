<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;

class PersonalInformationModel extends Model
{
    protected $table = 'employer_personal_info';


    protected $fillable = [

        'employer_id',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'employer_job_title',
        'employer_department',


    ];
}
