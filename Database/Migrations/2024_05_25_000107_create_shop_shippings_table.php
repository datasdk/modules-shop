<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('shop_shippings')) {

            Schema::create('shop_shippings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('shop_orders');
                $table->string('tracking_number')->nullable();
                $table->string('carrier');
                $table->decimal('shipping_cost', 10, 2);
                $table->timestamps();
            });
        
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('shop_shippings'))
        Schema::dropIfExists('shop_shippings');
    }
};
