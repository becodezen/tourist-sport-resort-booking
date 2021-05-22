<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perm_superadmin = Permission::whereNotIn('name', ['manage_booking'])->get();
        $perm_admin = Permission::whereNotIn('name', ['super_admin', 'manage_resort'])->get();
        $perm_manager = Permission::whereIn('name', ['manage_room','manage_booking', 'manage_account'])->get();

        // Super Admin Role
        $superAdmin = new Role();
        $superAdmin->name = 'super_admin';
        $superAdmin->display_name = 'Super Admin';
        $superAdmin->description = 'Has all permissions for super administrator';
        $superAdmin->save();
        $superAdmin->attachPermissions($perm_superadmin);

        // Admin/ Owner Role
        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = 'Admin';
        $admin->description = 'Has all permissions for admin';
        $admin->save();
        $admin->attachPermissions($perm_admin);

        // Manager Role
        $manager = new Role();
        $manager->name = 'manager';
        $manager->display_name = 'Manager';
        $manager->description = 'Has specific permission for manager';
        $manager->save();
        $manager->attachPermissions($perm_manager);

        // More to come here

    }
}
