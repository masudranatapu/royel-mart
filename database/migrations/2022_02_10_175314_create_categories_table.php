<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->integer('child_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->integer('menu')->default(0);
            $table->integer('feature')->default(0);
            $table->integer('serial_number')->default(0);
            $table->integer('parent_serial')->default(0);
            $table->integer('child_serial')->default(0);
            $table->integer('show_hide')->default(1);
            $table->integer('is_default')->default(0);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('categories');
    }
}
