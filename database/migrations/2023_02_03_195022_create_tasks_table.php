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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('created_user_id'); 
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('type_id'); 
            $table->foreign('type_id')->references('id')->on('task_types');
            $table->unsignedBigInteger('status_id'); 
            $table->foreign('status_id')->references('id')->on('task_statuses');
            $table->unsignedBigInteger('priority_id'); 
            $table->foreign('priority_id')->references('id')->on('task_priorities');
            $table->unsignedBigInteger('division_id'); 
            $table->foreign('division_id')->references('id')->on('divisions');
            $table->unsignedBigInteger('area_id'); 
            $table->foreign('area_id')->references('id')->on('areas');
            $table->dateTime('deadline')->nullable();
            $table->text('attachment')->nullable();
            $table->double('hours', 4, 2 )->default(0);
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
        Schema::dropIfExists('tasks');
    }
};
