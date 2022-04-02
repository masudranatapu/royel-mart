<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_stocks', function (Blueprint $table) {
            $table->id();
            $table->text('order_code');
            $table->text('purchase_code');
            $table->integer('product_id');
            $table->string('color_id')->nullable();
            $table->string('size_id')->nullable();
            $table->double('buying_price', 14,2)->default(0);
            $table->double('sale_price', 14,2)->default(0);
            $table->integer('quantity')->default(0);
            $table->double('total', 14,2)->default(0);
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
        Schema::dropIfExists('sale_stocks');
    }
}
