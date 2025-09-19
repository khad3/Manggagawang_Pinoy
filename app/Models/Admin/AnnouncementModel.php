<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AnnouncementModel extends Model
{
    protected $table = 'announcement_admins';

    
    protected $fillable = [
        'title',
        'content',
        'image',
        'priority',
        'target_audience',
        'publication_date',
        'status',
        'tag',
        'is_read',
    ];


    
}
