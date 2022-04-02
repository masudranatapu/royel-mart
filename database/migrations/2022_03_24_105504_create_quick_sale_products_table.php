<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickSaleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quick_sale_products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('quick_sale_id');
            $table->double('discount')->default(0);
            $table->text('discount_type')->default('Solid');
            $table->double('sale_price')->default(0);
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
        Schema::dropIfExists('quick_sale_products');
    }
}
