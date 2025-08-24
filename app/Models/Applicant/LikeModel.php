<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class LikeModel extends Model
{
    protected $table = 'forum_likes';

    protected $fillable = [
        'forum_post_id',
        'applicant_id',
        'likes',

    ];

    public function post()
    {
        return $this->belongsTo(PostModel::class, 'forum_post_id');
    }

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }

}
