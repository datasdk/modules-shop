<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        if (!Schema::hasTable('shop_cart_items')){

            Schema::create('shop_cart_items', function (Blueprint $table) {
                $table->id();

                // Relation til bruger
                $table->foreignId('user_id')->constrained('users');

                // Polymorfe relationer (kan pege på flere modeller: produkter, planer mv.)
                $table->unsignedBigInteger('purchasable_id');
                $table->string('purchasable_type');

                $table->integer('quantity');
                $table->timestamps();

                // Index til morph
                $table->index(['purchasable_id', 'purchasable_type']);
            });

        }

    }

    public function down()
    {
        if (Schema::hasTable('shop_cart_items')){
            
            Schema::dropIfExists('shop_cart_items');

        }
    }
};
