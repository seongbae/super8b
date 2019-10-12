<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkoutsTable extends Migration {

	public function up()
	{
		Schema::create('workouts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('focus')->nullable();
			$table->text('notes')->nullable();
			$table->integer('user_id');
			$table->string('duration')->nullable();
			$table->string('intensity')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('workouts');
	}
}