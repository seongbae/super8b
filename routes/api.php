<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/workouts/{planid}', function ($id) {
	$workouts = App\Models\Workout::where('plan_id', $id)->get();
    return $workouts;
});

Route::get('/exercises/{workoutid}', function ($id) {
	$workout = App\Models\Workout::with('exercises')->find($id);
    return $workout->exercises;
});

Route::get('/searchexercise',function(Request $request){
	$query = $request->get('query');
	$users = App\Models\Exercise::where('name','like','%'.$query.'%')->get();
	return response()->json($users);
});
