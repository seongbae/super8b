<?php 

namespace App;

use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\Plan;
use Auth;


class Helpers
{ 
  public static function getPlanName($id)
  {
      $plan = Plan::find($id);
      return $plan->name;
  }
  
}

?>