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

// Plan routes
Route::post('/plans/workout', function (Request $request) {
	$workout = App\Models\Workout::find($request->get('workout_id'));
	$plan = App\Models\Plan::find($request->get('plan_id'));
	$start_on = $request->get('start_on');

	$plan->workouts()->attach($workout->id, ['start_on'=>$start_on]);
});


Route::delete('/plans/workout/{planid}/{planWorkoutId}', function ($planId, $planWorkoutId) {
	$plan = App\Models\Plan::find($planId);
	$plan->workouts()->wherePivot('id', $planWorkoutId)->detach();
});

Route::post('/plans/workout/setdate', function (Request $request) {
	$plan = App\Models\Plan::find($request->get('plan_id'));
	$workout = App\Models\Workout::find($request->get('workout_id'));
	$parsed_date = Carbon\Carbon::parse($request->get('start_on'))->toDateTimeString();
	$plan->workouts()->updateExistingPivot($workout, array('start_on'=>$parsed_date));
});

Route::post('/plans/update_subscription', function (Request $request) {
	$plan = App\Models\Plan::find($request->get('plan_id'));
	$subscriber = App\Models\User::find($request->get('user_id'));

	if ($request->get('subscribe'))
		$plan->subscribers()->attach($subscriber);
	else
		$plan->subscribers()->detach($subscriber);
});

// Workout routes
Route::get('/workouts/{planid}', function ($id) {
	$plan = App\Models\Plan::find($id);

    return $plan->workouts; //()->withPivot('id','start_on','order');
});

Route::get('/exercises/{workoutid}', function ($id) {
	$workout = App\Models\Workout::with('exercises')->find($id);
    return $workout->exercises;
});

// Search routes
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

// User routes
Route::post('/user/workout/update_status', function (Request $request) {
	$planWorkout = App\Models\PlanWorkout::find($request->get('id'));
	$user = App\Models\User::find($request->get('user_id'));

	if ($request->get('completed'))
		$planWorkout->finishers()->attach($user);
	else
		$planWorkout->finishers()->detach($user);
});