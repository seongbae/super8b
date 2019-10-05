<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workout extends Model 
{

    protected $table = 'workouts';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function focuses()
    {
        return $this->hasMany('Focus', 'focus_id');
    }

    public function exercises()
    {
        return $this->hasMany('Exercise', 'exercise_id')->withPivot('rounds','repitition');
    }

}