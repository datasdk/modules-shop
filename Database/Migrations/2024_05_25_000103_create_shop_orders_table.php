<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('shop_orders')) {
            Schema::create('shop_orders', function (Blueprint $table) {
                $table->id();
                $table->string('type')->default("standard");
                $table->unsignedBigInteger('user_id')->nullable();
                $table->text('description')->nullable();
                $table->decimal('total', 10, 2);
                $table->string('currency');
                $table->string('status')->default('draft');

                // Payment info
                $table->string('payment_method')->nullable()->comment('fx: card, paypal, klarna');
                $table->string('payment_status')->default('unpaid')->comment('unpaid, paid, refunded, pending');
                $table->timestamp('paid_at')->nullable();
                $table->timestamp('refunded_at')->nullable();

                $table->text('notes')->nullable();

                $table->timestamps();
                $table->softDeletes();
            });

            Schema::table('shop_orders', function (Blueprint $table) {
                $table->index('user_id');
                $table->index('status');
                $table->index('payment_status');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('shop_orders');
    }
};
