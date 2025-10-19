<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportModel extends Model
{
    protected $table = 'report_n_i_users';

    protected $fillable = [
        'reporter_id',
        'reporter_type',
        'reported_id',
        'reported_type',
        'reason',
        'other_reason',
        'attachment',
        'additional_info',
        'employer_id',
    ];


    public function applicant()
    {
        return $this->belongsTo(\App\Models\Applicant\RegisterModel::class, 'reporter_id');
    }

    public function job()
    {
        return $this->belongsTo(\App\Models\Employer\JobDetailModel::class, 'reported_id', 'id');
    }

    public function employer()
    {
        return $this->belongsTo(\App\Models\Employer\AccountInformationModel::class, 'employer_id', 'id');
    }
}
