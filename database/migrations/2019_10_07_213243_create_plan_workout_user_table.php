<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanWorkoutUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_workout_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('plan_workout_id');
            $table->integer('user_id');
            $table->timestamp('completed_on')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_workout_user');
    }
}
