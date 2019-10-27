<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\Plan;
use Auth;
use Illuminate\Support\Facades\Log;

class WorkoutController extends Controller 
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
    $myWorkouts = Workout::where('user_id', Auth::id())->orderBy('name')->paginate(10);
    $allWorkouts = Workout::where('visibility','public')->orderBy('name')->paginate(10);
    $user = Auth::user();

    return view('workouts.index')->with('myworkouts', $myWorkouts)->with('allworkouts', $allWorkouts)->with('user', $user);
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
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function clone(Workout $workout)
  {
      //$workout->load('exercises');

      Log::info(json_encode($workout));

      $newModel = $workout->replicate();
      $newModel->visibility = 'private';
      $newModel->user_id = Auth::id();
      $newModel->push();

      foreach ($workout->getRelations() as $relationName => $values){
          $newModel->{$relationName}()->sync($values);
      }

      return redirect()->back();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show(Workout $workout)
  {
    return view('workouts.show')->with('workout', $workout);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit(Workout $workout)
  {
    $user = Auth::user();

    return view('workouts.edit')->with('workout', $workout)->with('user', $user);
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
  public function destroy(Workout $workout)
  {
       $workout->delete();

      return redirect('/workouts');
  }
  
}

?>