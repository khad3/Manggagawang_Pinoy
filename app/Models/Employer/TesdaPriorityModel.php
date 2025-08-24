<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;

class TesdaPriorityModel extends Model
{
    
    protected $table = 'employer_tesda_certi_priority';

    protected $fillable = [
        
        'employer_id',
        'personal_info_id',
        'tesda_priority'
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
