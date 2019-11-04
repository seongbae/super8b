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

Route::get('/terms', function () {
	return view('terms');
});

Route::get('/privacy', function () {
	return view('privacy');
});

Auth::routes();

Route::middleware('auth')->group(function () {
	
	Route::get('/home', 'HomeController@index')->name('home');

	Route::resource('workouts', 'WorkoutController');
	Route::get('workouts/copy/{workout}', 'WorkoutController@clone')->name('workouts.copy');
	Route::resource('plans', 'PlansController');
	Route::resource('exercises', 'ExerciseController');

	Route::resource('clone', 'CloneController');

	Route::get('/account', 'ProfileController@show')->name('user.profile');
	Route::view('/password', 'password');
	Route::get('/developer', 'ProfileController@showDeveloper');
	Route::get('/oauth2callback', 'ProfileController@handleOAuth2Callback');

	Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

	Route::get('body', 'HomeController@showBody');

});


// Route::get('plans', 'PlansController@index');
// Route::get('plans/{id}', 'PlansController@show');
// Route::get('plans/{id}', 'PlansController@show');