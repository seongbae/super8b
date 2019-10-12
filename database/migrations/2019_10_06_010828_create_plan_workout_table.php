<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanWorkoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_workout', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('plan_id');
            $table->integer('workout_id');
            $table->timestamp('start_on')->nullable();
            $table->string('location')->nullable();
            $table->integer('order')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_workout');
    }
}
