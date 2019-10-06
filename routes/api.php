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

Route::delete('/plans/workout/{planid}/{workoutid}', function ($planId, $workoutId) {
	$plan = App\Models\Plan::find($planId);
	$plan->workouts()->detach($workoutId);
});

Route::post('/plans/workout/setdate', function (Request $request) {
	$plan = App\Models\Plan::find($request->get('plan_id'));
	$workout = App\Models\Workout::find($request->get('workout_id'));
	$parsed_date = Carbon\Carbon::parse($request->get('start_on'))->toDateTimeString();
	$plan->workouts()->updateExistingPivot($workout, array('start_on'=>$parsed_date));
});

Route::get('/workouts/{planid}', function ($id) {
	$plan = App\Models\Plan::find($id);

    return $plan->workouts;
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

Route::get('/searchworkout',function(Request $request){
	$query = $request->get('query');
	$users = App\Models\Workout::where('name','like','%'.$query.'%')->get();
	return response()->json($users);
});
