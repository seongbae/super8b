<?php

use Illuminate\Database\Seeder;

class WorkoutExerciseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$exercises = App\Models\Exercise::all();

        App\Models\Workout::all()->each(function ($workout) use ($exercises) { 
		    $workout->exercises()->attach(
		        $exercises->random(rand(1, 4))->pluck('id')->toArray()
		    ); 
		});
    }
}
