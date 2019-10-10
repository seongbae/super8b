<?php

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;

class WorkoutTableSeeder extends CsvSeeder
{

	public function __construct()
    {
        $this->table = 'workouts';
        $this->filename = base_path().'/database/seeds/csvs/workouts.csv';
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        DB::table($this->table)->truncate();

        parent::run();

        //factory(App\Models\Workout::class, 50)->create();
    }
}
