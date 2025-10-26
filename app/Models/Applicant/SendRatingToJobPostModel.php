<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class SendRatingToJobPostModel extends Model
{
    protected $table = 'rating_job_post_by_applicant';


    protected $fillable = [
        'job_post_id',
        'applicant_id',
        'rating',
        'review_comments'
    ];

    public function jobPost()
    {
        return $this->belongsTo(\App\Models\Employer\JobDetailModel::class, 'job_post_id');
    }

    public function applicant()
    {
        return $this->belongsTo(\App\Models\Applicant\RegisterModel::class, 'applicant_id');
    }
}
