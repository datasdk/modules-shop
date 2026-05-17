<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('shop_order_items')) {
            Schema::create('shop_order_items', function (Blueprint $table) {
                $table->id();

                // foreignId med constraint til shop_orders.id med onDelete cascade
                $table->foreignId('order_id')->constrained('shop_orders')->onDelete('cascade');

                // Felter til produktet
                $table->string('product_name')->nullable();
                $table->text('description')->nullable();

                $table->integer('quantity');
                $table->decimal('price', 10, 2);
                $table->decimal('discount', 10, 2)->default(0);
                $table->decimal('total', 10, 2);

                // Polymorf relation (fx til produkter eller andet)
                $table->unsignedBigInteger('purchasable_id');
                $table->string('purchasable_type');

                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('shop_order_items');
    }
};
