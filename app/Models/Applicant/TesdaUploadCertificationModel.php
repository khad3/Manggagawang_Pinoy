<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\AddTesdaOfficerModel as TesdaOfficer;

class TesdaUploadCertificationModel extends Model
{
    protected $table = 'tesda_upload_certification';


    protected $fillable = [

        'applicant_id',
        'file_path',
        'certification_program',
        'certification_number',
        'certification_program_other',
        'certification_date_obtained',
        'status',
        'approved_by',
        'officer_comment'
    ];


    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }

    public function personal_info()
    {
        return $this->belongsTo(PersonalModel::class, 'applicant_id');
    }


    public function tesda_officer()
    {
        return $this->belongsTo(TesdaOfficer::class, 'approved_by');
    }
}
