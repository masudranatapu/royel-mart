<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use Carbon\Carbon;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Message::insert([
            'message' => '50',
            'sent' => '0',
            'created_at' => Carbon::now(),
        ]);
    }
}
