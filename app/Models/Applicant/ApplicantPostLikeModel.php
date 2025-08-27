<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class ApplicantPostLikeModel extends Model
{
    protected $table = 'applicant_post_likes';

    protected $fillable = [
        'post_id',
        'applicant_id',
        'likes',
    ];

    public function post()
    {
        return $this->belongsTo(ApplicantPostModel::class, 'post_id');
    }

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }
}
