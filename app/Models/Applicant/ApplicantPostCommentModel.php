<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class ApplicantPostCommentModel extends Model
{
    protected $table = 'applicant_post_comment';

    protected $fillable = [
        'post_id',
        'applicant_id',
        'comment',
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
