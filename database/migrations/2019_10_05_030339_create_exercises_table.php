<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExercisesTable extends Migration {

	public function up()
	{
		Schema::create('exercises', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->string('name', 255);
			$table->text('alternate_names')->nullable();
			$table->text('description')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('exercises');
	}
}