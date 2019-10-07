<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
   	public function subscribers()
    {
        return $this->belongsToMany('App\Models\User','plan_subscriber', 'plan_id', 'user_id')->withPivot('subscribed_on');
    }

    public function workouts()
    {
        return $this->belongsToMany('App\Models\Workout','plan_workout', 'plan_id', 'workout_id')->withPivot('id', 'start_on','order');
    }
}
