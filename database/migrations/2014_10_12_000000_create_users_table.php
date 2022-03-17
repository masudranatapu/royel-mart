<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->default(2);
            $table->string('name', 255);
            $table->string('email',100)->unique();
            $table->string('phone',20)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('address',1000)->nullable();
            $table->string('password',100);
            $table->string('image', 255)->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->integer('is_developer')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
