<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->text('time_zone')->default('Asia/Dhaka');
            $table->text('date_format')->default('dd-mm-yyyy');
            $table->text('time_format')->default('12 Hours');
            $table->text('currency')->default('৳');
            $table->double('shipping_charge')->default(0);
            $table->double('vat')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_settings');
    }
}
