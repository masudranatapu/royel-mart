<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Website;

class WebsiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Website::insert([
            'name' => 'Demo Name',
            'email' => 'demo@gmail.com',
            'phone'=> '01478523690',
            'address' => 'demo Address',
        ]);
    }
}
