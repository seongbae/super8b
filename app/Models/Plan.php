<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //

    public function workouts()
    {
        return $this->belongsToMany('App\Models\Workout','plan_workout', 'plan_id', 'workout_id')->withPivot('start_on','order');
    }
}
