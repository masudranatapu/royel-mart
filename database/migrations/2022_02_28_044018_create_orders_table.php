<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('order_code');
            $table->double('shipping_amount', 14,2)->default(0);
            $table->double('sub_total', 14,2)->default(0);
            $table->double('discount', 14,2)->default(0);
            $table->double('total', 14,2)->default(0);
            $table->double('paid', 14,2)->default(0);
            $table->double('due', 14,2)->default(0);
            $table->string('payment_method');
            $table->string('payment_mobile_number')->nullable();
            $table->string('payment_transaction_id')->nullable();
            $table->string('shipping_to')->nullable();
            $table->string('shipping_name')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('voucher')->nullable();
            $table->string('status')->default('Pending');
            $table->date('pending_date')->nullable();
            $table->date('confirmed_date')->nullable();
            $table->date('processing_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->date('successed_date')->nullable();
            $table->date('canceled_date')->nullable();
            $table->string('order_type')->default('General');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
