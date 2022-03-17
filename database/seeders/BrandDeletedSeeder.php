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
            'name' => 'Non-Branded',
            'slug' => 'non-branded',
            'image' => NULL,
            'is_default' => '1',
            'status' => '1',
            'created_at' => Carbon::now(),
        ]);
    }
}
