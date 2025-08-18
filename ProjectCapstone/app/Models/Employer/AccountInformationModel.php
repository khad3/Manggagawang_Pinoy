<?php

namespace App\Models\Employer;

use Faker\Provider\ar_EG\Company;
use Illuminate\Database\Eloquent\Model;

class AccountInformationModel extends Model
{
    protected $table = 'employer_account';

    protected $fillable = [

        'email',
        'password',
        'email_verified_at',
        'verification_token ',

    ];


    public function addressCompany() {
        return $this->hasOne(CompanyAdressModel::class, 'employer_id');
    }

    

    
}
