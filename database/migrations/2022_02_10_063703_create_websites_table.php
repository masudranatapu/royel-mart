<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->text('description')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_decription')->nullable();
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('tel')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->text('address');
            $table->string('footer_logo')->nullable();
            $table->text('twitter_api')->nullable();
            $table->text('google_map')->nullable();
            $table->text('facebook_pixel')->nullable();
            $table->text('google_analytics')->nullable();
            $table->text('schema')->nullable();
            $table->text('canonical_link')->nullable();
            $table->text('icon')->nullable();
            $table->text('link')->nullable();
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
        Schema::dropIfExists('websites');
    }
}
