<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AccountAdminModel extends Authenticatable
{

    use Notifiable;
    protected $table = 'account_super_admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login',
    ];

    protected $hidden = [
        'password',
       
    ];

   
}
