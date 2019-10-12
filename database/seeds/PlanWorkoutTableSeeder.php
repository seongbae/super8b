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
                'workout_id' => 5,
                'start_on' => '2019-10-15 00:00:00',
                'order' => 1
            ],
            [
                'id' => 2,
                'plan_id' => 1,
                'workout_id' => 6,
                'start_on' => '2019-10-16 00:00:00',
                'order' => 1
            ],
            [
                'id' => 3,
                'plan_id' => 1,
                'workout_id' => 7,
                'start_on' => '2019-10-17 00:00:00',
                'order' => 1
            ],
            [
                'id' => 4,
                'plan_id' => 1,
                'workout_id' => 8,
                'start_on' => '2019-10-22 00:00:00',
                'order' => 1
            ],
            [
                'id' => 5,
                'plan_id' => 1,
                'workout_id' => 9,
                'start_on' => '2019-10-23 00:00:00',
                'order' => 1
            ],
            [
                'id' => 6,
                'plan_id' => 1,
                'workout_id' => 10,
                'start_on' => '2019-10-24 00:00:00',
                'order' => 1
            ]
        ]
        );

    }
}
