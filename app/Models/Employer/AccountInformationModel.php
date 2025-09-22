<?php

namespace App\Models\Employer;

use Faker\Provider\ar_EG\Company;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\SuspensionModel;
use App\Models\Employer\CompanyAdressModel;

class AccountInformationModel extends Model
{
    protected $table = 'employer_account';

    protected $fillable = [

        'email',
        'password',
        'email_verified_at',
        'verification_token ',
        'status',

    ];


    public function addressCompany() {
        return $this->hasOne(CompanyAdressModel::class, 'employer_id');
    }

    public function personal_info() {
        return $this->hasOne(PersonalInformationModel::class, 'employer_id');
    }

    public function suspension() {
        return $this->hasOne(SuspensionModel::class, 'employer_id');
    }

    public function employer() {
        return $this->hasMany(SendMessageModel::class, 'employer_id');
    }

    
}
