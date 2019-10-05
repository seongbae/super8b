<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('workouts', function(Blueprint $table) {
			$table->foreign('workout')->references('id')->on('exercises')
						->onDelete('cascade')
						->onUpdate('no action');
		});
	}

	public function down()
	{
		Schema::table('workouts', function(Blueprint $table) {
			$table->dropForeign('workouts_workout_foreign');
		});
	}
}