<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanWorkout extends Model
{
	public $with = ['workout'];

    protected $table = 'plan_workout';

    public function finishers()
    {
        return $this->belongsToMany('App\Models\User','plan_workout_user', 'plan_workout_id', 'user_id')->withPivot('completed_on');
    }

    public function workout()
    {
    	return $this->hasOne('App\Models\Workout', 'id', 'workout_id');
    }

    public function plan()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id');
    }
}
