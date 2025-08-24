<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Admin\AccountAdminModel as AdminAccount;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminAccount::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@tesda.gov.ph',
            'password' => Hash::make('tesdadefaultpassword123'),
        ]);
    }
}
