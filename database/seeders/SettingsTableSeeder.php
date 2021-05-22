<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new Settings();
        $setting->is_weekend_price = 0;
        $setting->is_holiday_price = 0;
        $setting->is_vat_active = 0;
        $setting->vat = 0;
        $setting->vat_type = 'inclusive';
        $setting->save();
    }
}
