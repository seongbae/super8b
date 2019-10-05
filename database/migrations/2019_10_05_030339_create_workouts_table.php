<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkoutsTable extends Migration {

	public function up()
	{
		Schema::create('workouts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('workout')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('workouts');
	}
}