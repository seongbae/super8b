<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ExerciseTableSeeder::class);
        $this->call(WorkoutTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(WorkoutExerciseTableSeeder::class);
        $this->call(PlanWorkoutTableSeeder::class);
    }
}
