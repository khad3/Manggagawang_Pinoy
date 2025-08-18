<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Model;

class HiringTimelineModel extends Model
{
    
    protected $table = 'hiring_timeline';

    protected $fillable = [
        'personal_info_id',
        'employer_id',
        'hiring_timeline'
    ];

    public function personal_info()
    {
        return $this->belongsTo(PersonalInformationModel::class, 'personal_info_id');
    }

    public function employer()
    {
        return $this->belongsTo(AccountInformationModel::class, 'employer_id');
    }


}
