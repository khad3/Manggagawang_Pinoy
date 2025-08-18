<?php

namespace App\Models\Applicant;

use Illuminate\Database\Eloquent\Model;

class SendMessageModel extends Model
{
    protected $table = 'applicant_messages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'image_path',
        'is_read',
        'typing_indicator',
    ];


    public function sender()
    {
        return $this->belongsTo(RegisterModel::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(RegisterModel::class, 'receiver_id');
    }
}
