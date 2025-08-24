<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class ReplyModel extends Model
{
    protected $table = 'comment_replies';

    protected $fillable = [
        'reply',
        'forum_comment_id',
        'applicant_id',
    ];

 
 
    public function applicant()
    {
        return $this->belongsTo(RegisterModel::class, 'applicant_id');
    }
}
