<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;

class EmergencyContactModel extends Model
{
    protected $table = 'employer_provide_emergency_contact';

    protected $fillable = [
        'employer_id', 
        'personal_info_id',
        'first_name',
        'relation_to_company',
         'phone_number'
    ];

    public function personal_info()
    {
        return $this->belongsTo(PersonalInformationModel::class, 'personal_info_id');
    }

    public function employer()
    {
        return $this->belongsTo(AccountInformationModel::class, 'employer_id');
    }
}
