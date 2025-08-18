<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;

class CommunicationPreferenceModel extends Model
{
    
    protected $table = 'employer_communication_preferences';
    
    protected $fillable = [
        'employer_id', 
        'personal_info_id',
        'contact_method',
        'contact_time',
        'language_preference'

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
