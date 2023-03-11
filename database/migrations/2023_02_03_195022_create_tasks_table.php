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
            $table->string('task_title');
            $table->text('description');
            $table->unsignedBigInteger('user_id_created'); 
            $table->foreign('user_id_created')->references('id')->on('users');
            $table->unsignedBigInteger('user_id_assigned')->nullable(); 
            $table->foreign('user_id_assigned')->references('id')->on('users');
            $table->unsignedBigInteger('type_id'); 
            $table->foreign('type_id')->references('id')->on('task_types');
            $table->unsignedBigInteger('status_id')->default(1); 
            $table->foreign('status_id')->references('id')->on('task_statuses');
            $table->unsignedBigInteger('task_priority_id'); 
            $table->foreign('task_priority_id')->references('id')->on('task_priorities');
            $table->unsignedBigInteger('division_id'); 
            $table->foreign('division_id')->references('id')->on('divisions');
            $table->unsignedBigInteger('area_id'); 
            $table->foreign('area_id')->references('id')->on('areas');
            $table->date('deadline')->nullable();
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
