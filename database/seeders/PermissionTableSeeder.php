<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perm0 = new Permission();
        $perm0->name = 'super_admin'; // for super admin
        $perm0->display_name = 'Super Admin';
        $perm0->description = 'all kind of access for superadmin';
        $perm0->save();

        $perm1 = new Permission();
        $perm1->name = 'manage_admin'; // for super admin
        $perm1->display_name = 'Manage Admin';
        $perm1->description = 'Can create, edit or delete an admin';
        $perm1->save();

        $perm4 = new Permission();
        $perm4->name = 'manage_resort';
        $perm4->display_name = 'Manage Resort';
        $perm4->description = 'Can generate and manage resort';
        $perm4->save();

        $perm5 = new Permission();
        $perm5->name = 'manage_room';
        $perm5->display_name = 'Manage Room';
        $perm5->description = 'ca manage room';
        $perm5->save();

        $perm2 = new Permission();
        $perm2->name = 'manage_booking'; // for super admin
        $perm2->display_name = 'Manage Booking';
        $perm2->description = 'Can manage booking';
        $perm2->save();

        $perm3 = new Permission();
        $perm3->name = 'manage_settings'; // for admin
        $perm3->display_name = 'Manage';
        $perm3->description = 'Can manage settings';
        $perm3->save();

        $perm5 = new Permission();
        $perm5->name = 'manage_account';
        $perm5->display_name = 'Manage Account';
        $perm5->description = 'Can manage account';
        $perm5->save();

    }
}
