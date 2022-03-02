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
        // \App\Models\User::factory(10)->create();

         $this->call(UserTableSeeder::class);
         $this->call(RoleTableSeeder::class);
         $this->call(WebsiteTableSeeder::class);
         $this->call(AboutTableSeeder::class);
         $this->call(CategoryDeletedSeeder::class);
         $this->call(BrandDeletedSeeder::class);
         $this->call(MessageTableSeeder::class);
    }
}