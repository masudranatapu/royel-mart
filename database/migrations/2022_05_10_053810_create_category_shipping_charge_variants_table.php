<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryShippingChargeVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_shipping_charge_variants', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->double('qty_one_charge_variant', 14,2)->default(0);
            $table->double('qty_two_charge_variant', 14,2)->default(0);
            $table->double('qty_three_charge_variant', 14,2)->default(0);
            $table->double('qty_four_charge_variant', 14,2)->default(0);
            $table->double('qty_five_charge_variant', 14,2)->default(0);
            $table->double('qty_more_than_five_charge_variant', 14,2)->default(0);
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
        Schema::dropIfExists('category_shipping_charge_variants');
    }
}
