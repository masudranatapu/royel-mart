<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Carbon\Carbon;

class CategoryDeletedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Category::insert([
            'parent_id' => NULL,
            'child_id' => NULL,
            'name' => 'Uncategorized',
            'slug' => 'un-categorized',
            'image' => NULL,
            'status' => '1',
            'menu' => '1',
            'feature' => '1',
            'serial_number' => '0',
            'show_hide' => '0',
            'is_default' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
