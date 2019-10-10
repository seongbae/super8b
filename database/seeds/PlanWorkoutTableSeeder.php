<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PlanWorkoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plan_workout')->insert(
        [
            [
                'id' => 1,
                'plan_id' => 1,
                'workout_id' => 1,
                'start_on' => Carbon::now(),
                'order' => 1
            ]
        ]
        );

        //factory(App\Models\Plan::class, 50)->create();
    }
}
