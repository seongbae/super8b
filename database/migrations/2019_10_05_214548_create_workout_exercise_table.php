<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkoutExerciseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workout_exercise', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('workout_id');
            $table->integer('exercise_id');
            $table->string('repetition')->nullable();
            $table->integer('set')->nullable();
            $table->text('notes')->nullable();
            $table->integer('sort')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workout_exercise');
    }
}
