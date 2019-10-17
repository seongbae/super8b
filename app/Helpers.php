<?php 

namespace App;

use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\Plan;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Helpers
{ 
  public static function getPlanName($id)
  {
      $plan = Plan::find($id);
      return $plan->name;
  }
  
  public static function getActivityName($name, $rep, $set)
  {
  	$setLabel = '';
  	$repLabel = '';
    $activityName = '';

  	if ($set > 1)
  		$setLabel = 'sets';

  	if ($rep > 1)
  		$repLabel = 'repetitions';

    if ($set == '' && $rep == '')
      $activityName = $name;
    else 
  	 $activityName =  $name . ' ' . $set . ' ' . $setLabel . ' x ' . $rep . ' ' . $repLabel;

    return $activityName;
  }

  public static function fallsOnToday($dt)
  {
  	// if(Session::has('current_time_zone')){
   //     $current_time_zone = Session::get('current_time_zone');
   //     $utc = strtotime($attr)-date('Z'); // Convert the time zone to GMT 0. If the server time is what ever no problem.

   //     $current = $utc+$current_time_zone; // Convert the time to local time
   //     $current = date("Y-m-d", $attr);
   //  }
   //  else 
	  // 	$current = strtotime(date("Y-m-d"));

    $current = strtotime(date("Y-m-d"));
  	$date    = strtotime(date('Y-m-d', strtotime($dt)));

  	Log::info('fallsOnToday: today->'. date("Y-m-d") . ' variable: '.date('Y-m-d', strtotime($dt)));
  	Log::info('fallsOnToday: today->'. $current . ' variable: '.$date);

  	$datediff = $date - $current;
  	$difference = floor($datediff/(60*60*24));
  	
  	Log::info('fallsOnToday: difference->'. $difference);

  	if($difference==0)
  		return true;

  	return false;
  }

  public static function inFuture($dt)
  {
    $current = strtotime(date("Y-m-d"));
    $date    = strtotime(date('Y-m-d', strtotime($dt)));

    Log::info('fallsOnToday: today->'. date("Y-m-d") . ' variable: '.date('Y-m-d', strtotime($dt)));
    Log::info('fallsOnToday: today->'. $current . ' variable: '.$date);

    $datediff = $date - $current;
    $difference = floor($datediff/(60*60*24));
    
    Log::info('fallsOnToday: difference->'. $difference);

    if($difference>1)
      return true;

    return false;
  }
}

?>