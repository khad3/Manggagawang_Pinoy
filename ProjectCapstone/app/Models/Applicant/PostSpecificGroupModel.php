<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class PostSpecificGroupModel extends Model
{
    protected $table = 'per_group_posts';

    protected $fillable = [
        'group_community_id',
        'personal_info_id',
        'applicant_id',
        'title',
        'content',
        'image_path',
    ];

    public function groupCommunity()
    {
        return $this->belongsTo(GroupModel::class, 'group_community_id');
    }

    public function personalInfo()
    {
        return $this->belongsTo(PersonalModel::class, 'personal_info_id');
    }

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }

    public function comments()
{
    return $this->hasMany(GroupCommentModel::class, 'per_group_community_post_id');
}

public function work_background()
{
    return $this->belongsTo(ExperienceModel::class, 'work_experience_id');
}

public function likes()
{
    return $this->hasMany(GroupLikeModel::class, 'per_group_community_post_id');
}

}
