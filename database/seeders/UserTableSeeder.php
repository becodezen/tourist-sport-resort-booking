<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_superadmin = Role::where('name', 'super_admin')->first();
        $role_admin = Role::where('name', 'admin')->first();

        $superadmin = new User();
        $superadmin->name = 'Super Admin';
        $superadmin->username = 'superadmin';
        $superadmin->email = 'superadmin@vb.dev';
        $superadmin->password = bcrypt('password');
        $superadmin->save();
        $superadmin->attachRole($role_superadmin);

        $admin = new User();
        $admin->name = 'Admin';
        $admin->username = 'admin';
        $admin->email = 'admin@vb.dev';
        $admin->password = bcrypt('password');
        $admin->save();
        $admin->attachRole($role_admin);
    }
}
