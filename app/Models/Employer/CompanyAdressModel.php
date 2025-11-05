<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;

class CompanyAdressModel extends Model
{
    protected $table = 'employer_info_address';

    protected $fillable = [
        'employer_id',
        'personal_info_id',
        'company_name',
        'company_complete_address',
        'company_municipality',
        'company_zip',
        'company_province',
        'company_logo',
    ];

    public function personalInfo()
    {
        return $this->belongsTo(PersonalInformationModel::class, 'personal_info_id');
    }

    public function employer()
    {
        return $this->belongsTo(AccountInformationModel::class, 'employer_id');
    }
}
