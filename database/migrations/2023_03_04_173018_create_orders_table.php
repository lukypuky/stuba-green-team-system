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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('order_title');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->float('price_per_piece');
            $table->float('price_total');
            $table->unsignedBigInteger('currency_id'); 
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->unsignedBigInteger('created_by_user_id'); 
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->string('shop');
            $table->text('link');
            $table->unsignedBigInteger('order_priority_id'); 
            $table->foreign('order_priority_id')->references('id')->on('order_priorities');
            $table->text('order_comment')->nullable();
            $table->date('delivery_date')->nullable();
            $table->unsignedBigInteger('order_status_id'); 
            $table->foreign('order_status_id')->references('id')->on('order_statuses');
            $table->unsignedBigInteger('formula_part_specify_id'); 
            $table->foreign('formula_part_specify_id')->references('id')->on('formula_part_specifies');
            $table->boolean('approval')->nullable();
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
};
