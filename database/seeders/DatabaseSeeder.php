<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(PermissionTableSeeder::class);
        // $this->call(RoleTableSeeder::class);
        // $this->call(UserTableSeeder::class);

        //division, district and upazila seeder
        //$this->call(DivisionTableSeeder::class);
        //$this->call(DistrictTableSeeder::class);
        //$this->call(UpazilaTableSeeder::class);

        //setting table seed
        //$this->call(SettingsTableSeeder::class);

        //fake data seeder
        $this->call(FakeDataTableSeeder::class);
    }
}
