<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;

class AdditionalInformationModel extends Model
{
    protected $table = 'employer_additional_information';

    protected $fillable = [
        'employer_id',
        'personal_info_id',
        'typical_working_hours',
        'special_instructions_or_notes'

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
