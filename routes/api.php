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

Route::middleware('auth:api')->group(function () {
	Route::get('/user', function (Request $request) {
	    return $request->user();
	});

	// Plan routes

	// Create or update plans
	Route::post('/plan', function (Request $request) {
		$planId = $request->get('plan_id');
		$plan = App\Models\Plan::find($planId);

		if ($plan)
		{
			$plan->name = $request->get('name');
			$plan->description = $request->get('description');
			$plan->goals = $request->get('goals');
			$plan->user_id = $request->get('user_id');
			$plan->save();
		}
		else
		{
			$plan = new App\Models\Plan;
			$plan->name = $request->get('name');
			$plan->description = $request->get('description');
			$plan->goals = $request->get('goals');
			$plan->user_id = $request->get('user_id');
			$plan->save();
		}

		return $plan;
	});

	// Add workout to a plan
	Route::post('/plan/workout', function (Request $request) {
		$plan = App\Models\Plan::find($request->get('plan_id'));
		$workout = App\Models\Workout::find($request->get('workout_id'));
		$plan->workouts()->attach($workout, ['start_on'=>$request->get('start_on')]);
	});

	// Remove workout from a plan
	Route::delete('/plan/workout/{planid}/{planWorkoutId}', function ($planId, $planWorkoutId) {
		$plan = App\Models\Plan::find($planId);
		$plan->workouts()->wherePivot('id', $planWorkoutId)->detach();
	});

	// Set a date for workout when adding to a plan
	Route::post('/plan/workout/setdate', function (Request $request) {
		$plan = App\Models\Plan::find($request->get('plan_id'));
		$workout = App\Models\Workout::find($request->get('workout_id'));
		$parsed_date = Carbon\Carbon::parse($request->get('start_on'))->toDateTimeString();
		$plan->workouts()->updateExistingPivot($workout, array('start_on'=>$parsed_date));
	});

	// Set a date for workout when adding to a plan
	Route::get('/plan/{planid}/publish', function ($planId) {
		$plan = App\Models\Plan::find($planId);
		
		if ($plan)
		{
			$plan->status = 'published';
			$plan->save();
		}
	});

	Route::get('/plan/{planid}/unpublish', function ($planId) {
		$plan = App\Models\Plan::find($planId);
		
		if ($plan)
		{
			$plan->status = 'draft';
			$plan->save();
		}
	});

	// Subscribe/unsubscribe to a plan
	Route::post('/plan/update_subscription', function (Request $request) {
		$plan = App\Models\Plan::find($request->get('plan_id'));
		$subscriber = App\Models\User::find($request->get('user_id'));

		if ($request->get('subscribe'))
			$plan->subscribers()->attach($subscriber);
		else
			$plan->subscribers()->detach($subscriber);
	});

	// Workout routes

	// Retrieve workouts in a plan
	Route::get('/workout/{planid}', function ($id) {
		$plan = App\Models\Plan::find($id);
	    return $plan->workouts; //()->withPivot('id','start_on','order');
	});

	// Add exercise to a workout
	Route::post('/workout/exercise', function (Request $request) {
		$workout = App\Models\Workout::find($request->get('workout_id'));
		$exercise = App\Models\Exercise::find($request->get('exercise_id'));
		$workout->exercises()->attach($exercise, [
			'repetition'=>$request->get('repetition'), 
			'set'=>$request->get('set'), 
			'notes'=>$request->get('notes')
		]);
	});

	// Create or update existing workout
	Route::post('/workout', function (Request $request) {
		$workout = App\Models\Workout::find($request->get('workout_id'));

		if ($workout)
		{
			$workout->name = $request->get('name');
			$workout->focus = $request->get('focus');
			$workout->intensity = $request->get('intensity');
			$workout->duration = $request->get('duration');
			$workout->notes = $request->get('notes');
			$workout->user_id = $request->get('user_id');
			$workout->save();
		}
		else
		{
			$workout = new App\Models\Workout;
			$workout->name = $request->get('name');
			$workout->focus = $request->get('focus');
			$workout->intensity = $request->get('intensity');
			$workout->duration = $request->get('duration');
			$workout->notes = $request->get('notes');
			$workout->user_id = $request->get('user_id');
			$workout->save();
		}

		return $workout;
	});

	// Retrieve exercises in a workout
	Route::get('/workout/{workoutid}/exercises', function ($id) {
		$workout = App\Models\Workout::with('exercises')->find($id);
	    return $workout->exercises;
	});

	// Remove exercise from a workout
	Route::delete('/workout/{workoutid}/{exerciseid}', function ($workoutid, $workoutExerciseId) {
		$workout = App\Models\Workout::find($workoutid);
		$workout->exercises()->wherePivot('id', $workoutExerciseId)->detach();
	});

	// Search routes

	// Search exercises
	Route::get('/search/exercise',function(Request $request){
		$query = $request->get('query');
		$users = App\Models\Exercise::where('name','like','%'.$query.'%')->get();
		return response()->json($users);
	});

	// Search workouts
	Route::get('/search/workout',function(Request $request){
		$query = $request->get('query');
		$users = App\Models\Workout::where('name','like','%'.$query.'%')->get();
		return response()->json($users);
	});

	// User routes

	Route::get('/user/getAuthUser', function (Request $request) {
		return $request->user();
	});

	Route::put('/user/updateAuthUser', function (Request $request) {
		$validator = Validator::make($request->all(), [
           'name' => 'required|string',
	        'email' => 'required|email|unique:users,email,'.$request->user()->id
       	]);

		if ($validator->fails()) {
        	$errors = $validator->errors();
        	return response()->json(['error' => $errors], 400);
		}

	    $user = $request->user();
	    $user->name = $request->name;
	    $user->email = $request->email;
	    $user->save();

	    return $user;
	});

	Route::put('/user/updateAuthUserPassword', 'ProfileController@updateAuthUserPassword');

	// Mark workout complete
	Route::post('/user/workout/update_status', function (Request $request) {
		$planWorkout = App\Models\PlanWorkout::find($request->get('id'));
		$user = App\Models\User::find($request->get('user_id'));

		if ($request->get('completed'))
			$planWorkout->finishers()->attach($user);
		else
			$planWorkout->finishers()->detach($user);
	});
});
