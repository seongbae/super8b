<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkoutsTable extends Migration {

	public function up()
	{
		Schema::create('workouts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('user_id');
			$table->integer('plan_id')->nullable();
			$table->integer('duration')->nullable();
			$table->integer('intensity')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('workouts');
	}
}