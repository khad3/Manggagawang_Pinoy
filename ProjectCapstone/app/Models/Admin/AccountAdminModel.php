<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AccountAdminModel extends Model
{
    protected $table = 'account_super_admin';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
