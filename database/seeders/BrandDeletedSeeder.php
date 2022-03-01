<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Carbon\Carbon;

class BrandDeletedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Brand::insert([
            'name' => 'Unbranded',
            'slug' => 'un-branded',
            'image' => NULL,
            'status' => '1',
            'created_at' => Carbon::now(),
        ]);
    }
}
