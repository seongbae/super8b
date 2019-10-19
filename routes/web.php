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
	if (Auth::user())
		return redirect('/home');
	
    return view('welcome');
});

Route::get('/tabs', function () {
	return view('tabs');
});

Auth::routes();

Route::middleware('auth')->group(function () {
	
	Route::get('/home', 'HomeController@index')->name('home');

	Route::resource('workouts', 'WorkoutController');
	Route::resource('plans', 'PlansController');
	Route::resource('exercises', 'ExerciseController');

	Route::resource('clone', 'CloneController');

	Route::get('/profile', 'ProfileController@show');
	Route::view('/password', 'password');

	Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

});


// Route::get('plans', 'PlansController@index');
// Route::get('plans/{id}', 'PlansController@show');
// Route::get('plans/{id}', 'PlansController@show');