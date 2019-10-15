<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model 
{

    protected $table = 'exercises';
    public $timestamps = false;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function workouts()
    {
        return $this->belongsToMany('App\Models\Workout','workout_exercise', 'workout_id', 'exercise_id');
    }

    // // $exercise->
    // public function plans()
    // {
    // 	return $this->hasManyThrough('App\Models\Workout', 'App\Models\Plan');
    // }

}