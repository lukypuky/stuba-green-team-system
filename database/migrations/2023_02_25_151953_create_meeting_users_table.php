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
        Schema::create('meeting_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_status_id'); 
            $table->foreign('attendance_status_id')->references('id')->on('attendance_statuses');
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('meeting_id'); 
            $table->foreign('meeting_id')->references('id')->on('meetings');
            $table->string('absence');
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
        Schema::dropIfExists('meeting_users');
    }
};
