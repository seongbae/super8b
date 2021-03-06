<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;

class ServiceAPIController extends Controller 
{


  //private $client;

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
    

    //return view('')
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
      $exercise = new Exercise;
      $exercise->name = $request->get('exercise');
      $exercise->save();

      return redirect('/exercises');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
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
      $exercise = Exercise::find($id);
      $exercise->delete();

      return redirect('/exercises');
  }
  
}

?>