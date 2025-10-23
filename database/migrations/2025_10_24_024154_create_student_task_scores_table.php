<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('student_task_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // changed from student_id
            $table->unsignedBigInteger('task_id');
            $table->integer('score')->nullable();
            $table->timestamps();

            // link to users instead of students
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_task_scores');
    }
};
