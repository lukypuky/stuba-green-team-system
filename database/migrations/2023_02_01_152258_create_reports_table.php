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
        if(!Schema::hasTable('reports')){
            Schema::create('reports', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users');
                $table->unsignedBigInteger('task_id')->nullable(); //zatial
                $table->foreign('task_id')->references('id')->on('tasks');
                $table->char('color',10)->default('#4ca548');
                $table->char('textColor',10)->default('#000000');
                $table->dateTime('start_time')->nullable();
                $table->dateTime('end_time')->nullable();
                $table->timestamps();

                // $table->id('report_id');
                // $table->char('reason',100);
                // $table->dateTime('start_time');
                // $table->dateTime('end_time');
                // $table->unsignedSmallInteger('session');
                // $table->char('color',10)->default('#4ca548');
                // $table->char('textColor',10)->default('#000000');
                // $table->unsignedBigInteger('booked_by');
                // $table->unsignedBigInteger('user_id');
                // $table->foreign('user_id')->references('id')->on('users');
                // $table->timestamps();
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
        Schema::dropIfExists('reports');
    }
};
