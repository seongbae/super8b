<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Auth;

class PlansController extends Controller 
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
    $myPlans = Plan::with('author')->where('user_id', Auth::id())->paginate(15);
    $allPlans = Plan::with('author')->where('status', 'published')->paginate(15);
    $subscribedplans = Auth::user()->subscribedPlans()->paginate(15);

    return view('plans.index')
          ->with('myplans', $myPlans)
          ->with('allplans', $allPlans)
          ->with('subscribedplans', $subscribedplans);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $user = Auth::user();
     return view('plans.create')->with('user', $user);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
      Workout::save($request);

      return redirect('/home');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $plan = Plan::with('workouts')->find($id);
    $user = Auth::user();

    return view('plans.show')->with('plan', $plan)->with('user', $user);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $user = Auth::user();
    $plan = Plan::with('author')->with('workouts')->find($id);

    return view('plans.edit')->with('plan', $plan)->with('user', $user);
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