<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemSetting::insert([
            'time_zone'=> 'Asia/Dhaka',
            'date_format' => 'dd-mm-yyyy',
            'time_format' => '12 Hours',
            'currency' => '৳',
            'shipping_charge' => 0,
            'vat' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
