<?php

namespace App\Models\Employer;

use App\Models\Applicant\RegisterModel;
use Illuminate\Database\Eloquent\Model;

class SendRatingModel extends Model
{
    
    protected $table = 'rating_applicant_ni_employer';

    protected $fillable = [

        'applicant_id',
        'employer_id',
        'rating',
        'review_comments',
    
    ];


    public function employer()
    {
        return $this->belongsTo(AccountInformationModel::class, 'employer_id');
    }

    public function addressCompany() {
        return $this->hasOne(CompanyAdressModel::class, 'employer_id');
    }

    public function personalInfo() {
    return $this->belongsTo(PersonalInformationModel::class, 'employer_id', 'employer_id');
}

    public function applicant() {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }

    
}
