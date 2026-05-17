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

        if (!Schema::hasTable('shop_products')){

            Schema::create('shop_products', function (Blueprint $table) {
                $table->id();
                $table->string('type');
                $table->string('name');
                $table->text('description');
                $table->string('slug');
                $table->decimal('price', 10, 2)->default(0);
                $table->decimal('discount', 10, 2)->default(0);
                $table->string('status');
                $table->integer('sorting');
                $table->timestamps();
                $table->softDeletes();
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
        if (Schema::hasTable('shop_products')){
            
            Schema::dropIfExists('shop_products');

        }
    }
};
