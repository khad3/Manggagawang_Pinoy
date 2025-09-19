<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserManagmentModel extends Model
{
    
    protected $table = 'admin_user_management';

    protected $fillable = [
        'user_id',
        'type_user', 
        'status', 
        'reason',
        'reason_description',
        'suspension_duration',
        'registration_date',
        'last_login',
    ];

    /**
     * Computed status based on last login
     */
    public function getComputedStatusAttribute()
    {
        if ($this->type_user === 'applicant' && $this->last_login) {
            $lastLogin = Carbon::parse($this->last_login);
            return $lastLogin->greaterThanOrEqualTo(now()->subDays(5)) ? 'Active' : 'Inactive';
        }

        return $this->status ?? 'N/A';
    }

    /**
     * Relationship to applicant
     * admin_user_management.user_id -> applicants.id
     */
    public function applicant()
    {
        return $this->belongsTo(\App\Models\Applicant\RegisterModel::class, 'user_id', 'id');
    }

    /**
     * Nested relationship to personal info
     */
    public function applicantPersonalInfo()
    {
        return $this->hasOneThrough(
            \App\Models\Applicant\PersonalModel::class, // target model
            \App\Models\Applicant\RegisterModel::class,     // intermediate model
            'id',        // Foreign key on RegisterModel (applicant_id) that links to PersonalInfo
            'applicant_id', // Foreign key on PersonalInfoModel
            'user_id',   // Local key on this table (admin_user_management.user_id)
            'id'        // Local key on intermediate table (RegisterModel.id)
        );
    }

    /**
     * Relationship to employer
     * admin_user_management.user_id -> employers.id
     */
    public function employer()
    {
        return $this->belongsTo(\App\Models\Employer\AccountInformationModel::class, 'user_id', 'id');
    }
}
