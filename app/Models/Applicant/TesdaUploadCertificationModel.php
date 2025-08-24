<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
