<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanWorkout extends Model
{
    protected $table = 'plan_workout';

    public function finishers()
    {
        return $this->belongsToMany('App\Models\User','plan_workout_user', 'plan_workout_id', 'user_id');
    }
}
