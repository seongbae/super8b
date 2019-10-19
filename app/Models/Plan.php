<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;

class Plan extends Model
{
    use Hashidable;

	public function author()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
	
   	public function subscribers()
    {
        return $this->belongsToMany('App\Models\User','plan_subscriber', 'plan_id', 'user_id')->withPivot('subscribed_on');
    }

    public function workouts()
    {
        return $this->belongsToMany('App\Models\Workout','plan_workout', 'plan_id', 'workout_id')->withPivot('id', 'start_on','order');
    }
}
