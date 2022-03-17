<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::insert([
            'role_id'=> '1',
            'name' => 'Projanmo IT',
            'email' => 'admin@projanmoit.com',
            'is_developer' => '1',
            'password' => bcrypt('Proit@2021.com'),
        ]);

        User::insert([
            'role_id'=> '1',
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'is_developer' => '0',
            'password' => bcrypt('123456'),
        ]);

        User::insert([
            'role_id'=> '1',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'is_developer' => '0',
            'password' => bcrypt('123456'),
        ]);
    }
}
