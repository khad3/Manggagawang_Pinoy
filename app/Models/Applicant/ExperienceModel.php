<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class ExperienceModel extends Model
{
    protected $table = 'work_experiences';

    protected $fillable = [
        'applicant_id',
        'position',
        'other_position',
        'work_duration',
        'work_duration_unit',
        'employed',
        'profileimage_path',
        'cover_photo_path',
    ];

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }
}
