<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quick_sales', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('slug')->unique();
            $table->text('image')->nullable();
            $table->text('start_date_time');
            $table->text('end_date_time');
            $table->double('discount')->default(0);
            $table->text('discount_type')->default('Solid');
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
        Schema::dropIfExists('quick_sales');
    }
}
