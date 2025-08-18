<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class GroupCommentModel extends Model
{
    protected $table = 'group_community_comments';


    protected $fillable = [
        'per_group_community_post_id',
        'group_community_id',
        'applicant_id',
        'personal_info_id',
        'comment',
        'work_experience_id',
    ];


   public function personal_info()
{
    return $this->belongsTo(PersonalModel::class, 'personal_info_id');
}

public function work_experience()
{
    return $this->belongsTo(ExperienceModel::class, 'work_experience_id');
}


    public function group()
    {
        return $this->belongsTo(GroupModel::class, 'group_community_id');
    }

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }

    public function groupPost()
    {
        return $this->belongsTo(PostSpecificGroupModel::class, 'per_group_community_post_id');
    }

}
