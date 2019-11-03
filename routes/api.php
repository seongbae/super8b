<?php

use Illuminate\Http\Request;
use App\Services\PlansService;
use Illuminate\Support\Facades\Log;
use App\Services\WorkoutServiceInterface;

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
	Route::post('/plan', function (Request $request, WorkoutServiceInterface $wsp) {
		$planId = $request->get('plan_id');
		$plan = App\Models\Plan::find($planId);

		if ($plan)
		{
			$plan = $wsp->updatePlan(
				$request->get('plan_id'),
				$request->get('name'), 
				$request->get('description'), 
				$request->get('goals'), 
				$request->get('user_id')
			);			
		}
		else
		{
			$plan = $wsp->createPlan(
				$request->get('name'), 
				$request->get('description'), 
				$request->get('goals'), 
				$request->get('user_id')
			);
		}

		if ($plan)
			return response()->json($plan, 201);
		else
			return response()->json(null, 204);
	});

	// Delete plan
	Route::delete('/plan', function (Request $request, WorkoutServiceInterface $wsp) {
		$planId = $request->get('plan_id');
		$plan = App\Models\Plan::find($planId);

		if ($plan)
		{
			$wsp->deletePlan($plan);
			return response()->json(null, 204);
		}
		else
			return response()->json(null, 404);
	});

	// Add workout to a plan
	Route::post('/plan/workout', function (Request $request, WorkoutServiceInterface $wsp) {
		$plan = App\Models\Plan::find($request->get('plan_id'));
		$workout = App\Models\Workout::find($request->get('workout_id'));

		if ($plan && $workout)
		{
			$wsp->addWorkoutToPlan($plan, $workout, $request->get('start_on'));
			return response()->json(null, 202);
		}
		else
		{
			response()->json(null, 400);
		}
	});

	// Remove workout from a plan
	Route::delete('/plan/workout/{planid}/{planWorkoutId}', function ($planId, $planWorkoutId, WorkoutServiceInterface $wsp) {
		$plan = App\Models\Plan::find($planId);

		if ($plan && $planWorkoutId)
		{
			$wsp->removeWorkoutFromPlan($plan, $planWorkoutId);

			return response()->json(null, 202);
		}
		else
		{
			response()->json(null, 400);
		}
		
	});

	// Set a date for workout when adding to a plan
	// Route::post('/plan/workout/setdate', function (Request $request, WorkoutServiceInterface $wsp) {
	// 	$plan = App\Models\Plan::find($request->get('plan_id'));
	// 	$workout = App\Models\Workout::find($request->get('workout_id'));
	// 	$parsed_date = Carbon\Carbon::parse($request->get('start_on'))->toDateTimeString();

	// 	$plan->workouts()->updateExistingPivot($workout, array('start_on'=>$parsed_date));
	// });

	// Publish a plan
	Route::get('/plan/{planid}/publish', function ($planId, App\Services\PlansService $service) {
		$service->publish($planId);
	});

	// Unpublish a plan
	Route::get('/plan/{planid}/unpublish', function ($planId, App\Services\PlansService $service) {
		$service->unpublish($planId);
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
	    return $plan->workouts()->orderBy('start_on')->get(); //()->withPivot('id','start_on','order');
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
			$workout->visibility = $request->get('visibility');
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
			$workout->visibility = $request->get('visibility');
			$workout->save();
		}

		if ($request->get('plans')) 
		{
			foreach($request->get('plans') as $plan)
			{
				$plan = App\Models\Plan::find($plan['id']);

				$plan->workouts()->attach($workout, ['start_on'=>Carbon\Carbon::now()]);
			}
		}

		return $workout;
	});

	// Retrieve exercises in a workout
	Route::get('/workout/{workoutid}/exercises', function ($id) {
		$workout = App\Models\Workout::with('exercises')->find($id);
	    return $workout->exercises()->orderBy('sort')->get();
	});

	// Remove exercise from a workout
	Route::delete('/workout/{workoutid}/{exerciseid}', function ($workoutid, $workoutExerciseId) {
		$workout = App\Models\Workout::find($workoutid);
		$workout->exercises()->wherePivot('id', $workoutExerciseId)->detach();
	});

	Route::post('/workout/exercise/update_order', function (Request $request) {
		$workout = App\Models\Workout::find($request->get('workout_id'));
		$orderedExercises = $request->get('exercises');

		$order = 1;
		foreach($orderedExercises as $exercise)
		{
			$workout->exercises()->wherePivot('id', $exercise['pivot']['id'])->updateExistingPivot($exercise['id'], array('sort' => $order));
			$order++;
		}
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
		$userId = $request->get('user_id');
		$workouts = App\Models\Workout::where('user_id',$userId)->where('name','like','%'.$query.'%')->get();
		return response()->json($workouts);
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

	// Mark workout complete
	Route::get('/plan/workout/{planworkoutid}/completed', function ($planworkoutid) {
		$planWorkout = App\Models\PlanWorkout::find($planworkoutid);
		return $planWorkout->finishers()->orderBy('completed_on', 'desc')->get();
	});

	Route::post('/user/remove_integration', function (Request $request) {
		$user = App\Models\User::find($request->get('user_id'));
		$user->gcalendar_credentials = null;
        $user->gcalendar_integration_active = 0;
        $user->save();
		
	});
});
