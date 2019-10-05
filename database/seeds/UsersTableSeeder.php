<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Seong Bae',
            'email' => 'bae.seong@hotmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
