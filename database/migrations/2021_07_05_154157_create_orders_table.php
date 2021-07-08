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
            $table->id();
            $table->integer('user_id');
            $table->string('customer_id')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('product_id')->nullable();
            $table->float('product_price')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('currency')->nullable();
            $table->float('paid_amount')->nullable();
            $table->string('discount_code')->nullable();
            $table->float('discount_amount')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('is_paid')->default(0);
            $table->boolean('is_quota_added')->default(0);
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
