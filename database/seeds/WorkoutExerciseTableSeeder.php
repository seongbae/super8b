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
        // $workout_exercises = array(

        // );

        DB::table('workout_exercise')->insert(
        [
            [
                'workout_id' => 1,
                'exercise_id' => 84,
                'repetition' => '10',
                'set' => 1
            ],
            [
                'workout_id' => 1,
                'exercise_id' => 84,
                'repetition' => '5',
                'set' => 5
            ],
            [
                'workout_id' => 1,
                'exercise_id' => 74,
                'repetition' => '1500m',
                'set'=>null
            ]
        ]
        );
  //   	$exercises = App\Models\Exercise::all();

  //       App\Models\Workout::all()->each(function ($workout) use ($exercises) { 
		//     $workout->exercises()->attach(
		//         $exercises->random(rand(1, 4))->pluck('id')->toArray()
		//     ); 
		// });
    }
}
