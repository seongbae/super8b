<?php

use Illuminate\Database\Seeder;

class WorkoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Workout::class, 50)->create();
    }
}
