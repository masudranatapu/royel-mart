<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('product_code');
            $table->string('category_id');
            $table->string('brand_id')->nullable();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('slug');
            $table->string('thumbnail')->nullable();
            $table->text('more_image')->nullable();
            $table->double('regular_price');
            $table->double('sale_price');
            $table->double('discount', 14,2)->default(0);
            $table->double('discount_tk', 14,2)->default(0);
            $table->double('shipping_charge', 14,2)->default(0);
            $table->double('inside_shipping_charge', 14,2)->default(0);
            $table->double('outside_shipping_charge', 14,2)->default(0);
            $table->integer('free_shipping_charge')->default(0);
            $table->integer('alert_quantity')->default(0);
            $table->longText('description')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('outside_delivery')->nullable();
            $table->text('return_status')->nullable();
            $table->text('inside_delivery')->nullable();
            $table->text('cash_delivery')->nullable();
            $table->text('payment_method')->nullable();
            $table->text('guarantee_policy')->nullable();
            $table->text('warranty_policy')->nullable();
            $table->string('schema')->nullable();
            $table->string('product_type')->nullable();
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
        Schema::dropIfExists('products');
    }
}
