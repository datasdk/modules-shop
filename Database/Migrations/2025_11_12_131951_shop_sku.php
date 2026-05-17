<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopSku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('shop_skus'))
        Schema::create('shop_skus', function (Blueprint $table) {
            $table->id();

            // Polymorphic relation
            $table->string('skuable_type');
            $table->unsignedBigInteger('skuable_id');
            $table->index(['skuable_type', 'skuable_id']);

            // SKU-felter
            $table->string('sku')->unique();
 

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

        if (Schema::hasTable('shop_skus'))
        Schema::dropIfExists('shop_skus');
    }
}
