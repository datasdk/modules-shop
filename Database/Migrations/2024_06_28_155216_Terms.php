<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Terms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('shop_terms')) {

            Schema::create('shop_terms', function ($table) {
                $table->id();
                $table->string('title');
                $table->text('content');
                $table->string('slug');
                $table->integer('sorting')->nullable();
                $table->softDeletes();
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
        
        if (Schema::hasTable('shop_terms')) {
            Schema::dropIfExists('shop_terms');
        }

    }
};
