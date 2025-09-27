<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;
use App\Models\Applicant\RegisterModel;
use App\Models\Employer\AccountInformationModel as EmployerModel;

class SendMessageModel extends Model
{
    protected $table = 'employer_messages_to_applicant';

    protected $fillable = [
            'employer_id', 
            'applicant_id', 
            'message',
            'attachment',
            'is_read',
            'sender_type',
    ];


    public function employer()
    {
        return $this->belongsTo(EmployerModel::class, 'employer_id');
    }
    

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }
}
