<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //

    public function workouts()
    {
        return $this->hasMany('App\Models\Workout');
    }
}
