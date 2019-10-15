<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExercisesTable extends Migration {

	public function up()
	{
		Schema::create('exercises', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('focus_area')->nullable();
			$table->text('alternate_names')->nullable();
			$table->text('description')->nullable();
			$table->softDeletes();
			
		});
	}

	public function down()
	{
		Schema::drop('exercises');
	}
}