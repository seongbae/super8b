<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('workouts', 'WorkoutController');
Route::resource('plans', 'PlansController');
Route::resource('exercise', 'ExerciseController');
Route::resource('focus', 'FocusController');

Route::get('/create', 'WorkoutController@create');

// Route::get('plans', 'PlansController@index');
// Route::get('plans/{id}', 'PlansController@show');
// Route::get('plans/{id}', 'PlansController@show');