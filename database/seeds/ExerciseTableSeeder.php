<?php

use Illuminate\Database\Seeder;

class ExerciseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('exercises')->insert([
            ['id'=>1, 'name' => 'Dumbbell Bench Press'],
            ['id'=>2, 'name' => 'Flat Chest Press Machine'],
            ['id'=>3, 'name' => 'Incline Chest Press Machine'],
            ['id'=>4, 'name' => 'Decline Chest Press Machine']
        ]);
    }
}
