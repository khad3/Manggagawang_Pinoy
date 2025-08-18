<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class GroupLikeModel extends Model
{
    protected $table = 'per_group_post_likes';


    protected $fillable = [
        'group_community_id',
        'per_group_community_post_id',
        'applicant_id',
        'personal_info_id',
        'likes',
    ];


    public function group()
    {
        return $this->belongsTo(GroupModel::class, 'group_community_id');
    }

    public function group_post()
    {
        return $this->belongsTo(PostModel::class, 'per_group_community_post_id');
    }

    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }

    public function personal_info()
    {
        return $this->belongsTo(PersonalModel::class, 'personal_info_id');
    }
}
