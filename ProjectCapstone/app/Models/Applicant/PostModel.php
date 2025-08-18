<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    protected $table = 'forum_posts';

    protected $fillable = [
        'title',
        'content',
        'image_path',
        'category',
        'applicant_id',
        'personal_info_id',
        'work_experience_id',
    ];

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }

    public function personalInfo()
    {
        return $this->belongsTo(PersonalModel::class, 'personal_info_id');
    }

    public function workBackground()
    {
        return $this->belongsTo(ExperienceModel::class, 'personal_info_id');
    }

    public function comments()
    {
        return $this->hasMany(CommentModel::class, 'forum_post_id');
    }

    public function ReplyComments()
    {
        return $this->hasMany(ReplyModel::class, 'forum_post_id');
    }

    public function likes()
{
    return $this->hasMany(LikeModel::class, 'forum_post_id');
}
}
