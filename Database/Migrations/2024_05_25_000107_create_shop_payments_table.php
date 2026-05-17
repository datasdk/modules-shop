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
        if (!Schema::hasTable('shop_payments')){

            Schema::create('shop_payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('shop_orders');
                $table->decimal('amount', 10, 2);
                $table->string('payment_method');
                $table->string('status');
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
        if (Schema::hasTable('shop_payments')){
            
            Schema::dropIfExists('shop_payments');

        }
    }
}
;