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
                'id' => 1,
                'workout_id' => 5,
                'exercise_id' => 3,
                'repetition' => '30',
                'set' => 1,
                'notes'=>'bodyweight'
            ],
            [
                'id' => 2,
                'workout_id' => 5,
                'exercise_id' => 74,
                'repetition' => '1500m',
                'set' => 1,
                'notes'=>null
            ],
            [
                'id' => 3,
                'workout_id' => 6,
                'exercise_id' => 71,
                'repetition' => '5',
                'set'=>null,
                'notes'=>'Odd minutes. (135/95)'
            ],
            [
                'id' => 4,
                'workout_id' => 6,
                'exercise_id' => 5,
                'repetition' => '5',
                'set'=>1,
                'notes'=>'Even minutes. (205/135)'
            ],
            [
                'id' => 5,
                'workout_id' => 6,
                'exercise_id' => 110,
                'repetition' => '12',
                'set'=>3,
                'notes'=>null
            ]
        ]
        );
    }
}
