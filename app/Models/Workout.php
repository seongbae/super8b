<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Hashidable;

class Workout extends Model 
{
    use Hashidable;
    
    protected $table = 'workouts';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function author() 
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function focuses()
    {
        return $this->hasMany('Focus', 'focus_id');
    }

    public function exercises()
    {
        return $this->belongsToMany('App\Models\Exercise','workout_exercise', 'workout_id', 'exercise_id')->withPivot('set','repetition','id','notes','sort');
    }

    public function plan()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id');
    }

    public function finishers()
    {
        
    }
}