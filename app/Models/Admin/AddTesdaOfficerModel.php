<?php

namespace App\Models\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class AddTesdaOfficerModel extends Authenticatable
{

    use Notifiable;
    protected $table = 'tesda_officers';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'temporary_password',
        'password',
        'status',
    ];


    protected $hidden = [
        'temporary_password',
        'password',
    ];
}
