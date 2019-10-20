<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Workout;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CloneController extends Controller 
{

  /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
   
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create(Plan $plan)
  {
     return view('clone')->with('plan', $plan);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    $newPlan = new Plan;
    $newPlan->name = $request->get('name');
    $newPlan->description = $request->get('description');
    $newPlan->goals = $request->get('goals');
    $newPlan->user_id = Auth::id();
    $newPlan->save();

    $fromPlan = Plan::find($request->get('plan_id'));
    $startOn = $request->get('start_date');
    $newStarton = new Carbon($startOn);
    Log::info('newStarton: '.$newStarton);
    $index = 0;
    $addDays = 0;

    foreach($fromPlan->workouts as $workout)
    {
      $newWorkout = new Workout;
      $newWorkout->name = $workout->name;
      $newWorkout->notes = $workout->notes;
      $newWorkout->focus = $workout->focus;
      $newWorkout->user_id = Auth::id();
      $newWorkout->save();

      $workoutStarton = new Carbon($workout->pivot->start_on);
        
      if ($index == 0)
        $addDays = $newStarton->diffInDays($workoutStarton); //$workoutStarton->diffInDays($newStarton);
      else
        $startOn = $workoutStarton->addDays($addDays);

      Log::info('startOn: '.$startOn);
      $newPlan->workouts()->attach($newWorkout, array('start_on'=>$startOn));
      $index++;
    }

    return redirect('/plans');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show(Plan $plan)
  {
     return view('clone')->with('plan', $plan);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    
  }
  
}

?>