<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanWorkoutUser extends Model
{
	// public $with = ['plan_workout'];

	protected $dates = ['completed_on'];

    protected $table = 'plan_workout_user';

    public function planWorkout()
    {
    	return $this->hasOne('App\Models\PlanWorkout', 'id', 'plan_workout_id');
    }

}
