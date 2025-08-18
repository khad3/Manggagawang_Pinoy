<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;

class SpecialRequirementModel extends Model
{
    protected $table = 'special_requirements_table';

    protected $fillable = [
        
        'employer_id',
        'personal_info_id',
        'special_requirement',
        'additional_requirements_or_notes'

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
