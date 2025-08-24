<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    protected $table = 'forum_comments';

    protected $fillable = [
        'forum_post_id',
        'applicant_id',
        'comment',
    ];

    public function post()
    {
        return $this->belongsTo(PostModel::class, 'forum_post_id');
    }

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }

    public function replies()
    {
        return $this->hasMany(ReplyModel::class, 'forum_comment_id');
    }
}
