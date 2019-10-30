<?php 

namespace App;

use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\Plan;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

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
    $x = '';

    if ($set > 1)
  		$setLabel = 'sets';
    elseif ($set == 1)
      $setLabel = 'set';

  	if ($rep > 1)
  		$repLabel = 'repetitions';
    elseif ($rep == 1)
      $repLabel = 'repetition';

    if ($set >= 1 && $rep >= 1)
      $x = ' x ';

    if ($set == '' && $rep == '')
      $activityName = $name;
    else 
  	 $activityName =  $name . ' ' . $set . ' ' . $setLabel . $x . $rep;

    return $activityName;
  }

  public static function fallsOnToday($dt)
  {
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

    if($difference>=1)
      return true;

    return false;
  }

  public static function getLocalDateTime($dt, $tz)
  {
    $date = Carbon::createFromFormat('Y-m-d H:i:s', $dt, config('app.server_timezone'));
    $date->setTimezone($tz);
    return $date->format('g:i A m/d/Y');
  }
}

?>