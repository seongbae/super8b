<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\Plan;
use Auth;


class WorkoutController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $myWorkouts = Workout::where('user_id', Auth::id())->paginate(15);
    $allWorkouts = Workout::paginate(15);

    return view('workouts.index')->with('myworkouts', $myWorkouts)->with('allworkouts', $allWorkouts);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $user = Auth::user();

    return view('workouts.create')->with('user', $user);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
      // $workout = new Workout;
      // $workout->name = $request->get('name');

      // if ($request->get('plan_id'))
      //   $workout->plan_id = $request->get('plan_id');
      

      //return redirect('/home');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $workout = Workout::find($id);

    return view('workouts.show')->with('workout', $workout);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $workout = Workout::find($id);

    return view('workouts.edit')->with('workout', $workout);
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