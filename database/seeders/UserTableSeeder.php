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
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        User::insert([
            'role_id'=> '1',
            'name' => 'Projanmo IT',
            'email' => 'admin@projanmoit.com',
            'password' => bcrypt('Proit@2021.com'),
        ]);
    }
}
