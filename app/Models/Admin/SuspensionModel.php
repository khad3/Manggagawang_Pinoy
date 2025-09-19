<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SuspensionModel extends Model
{
    protected $table = 'suspended_users_table';

    protected $fillable = [
        'applicant_id',
        'employer_id',
        'reason',
        'other_reason',
        'additional_info',
        'suspension_duration',
    ];



    public function applicant()
    {
        return $this->belongsTo(\App\Models\Applicant\RegisterModel::class, 'applicant_id', 'id');
    }

    public function employer()
    {
        return $this->belongsTo(\App\Models\Employer\AccountInformationModel::class, 'employer_id', 'id');
    }
    
}
