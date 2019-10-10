<?php

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
            'name' => 'CGSC Class of 2020 SG8B Workout Plan',
            'description' => 'This workout plan is created by CPT(P) Billy Folinuiz at CGSC Student Group 8B Class of 2020.  The goal is to help you pass ACFT.',
            'user_id' => 1
        ]);

        //factory(App\Models\Plan::class, 50)->create();
    }
}
