<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function plans()
    {
        return $this->hasMany('App\Models\Plan','user_id');
    }

    public function workouts()
    {
        return $this->hasMany('App\Models\Workout','user_id');
    }

    public function subscribedPlans()
    {
        return $this->belongsToMany('App\Models\Plan','plan_subscriber', 'plan_id', 'user_id')->withPivot('subscribed_on');
    }

    public function subscribed($plan)
    {
        // Log::info($this);
        // Log::info($plan);

        foreach($this->subscribedPlans as $subscribedPlan)
        {
            Log::info('subscribedPlan->id: '. $subscribedPlan->id . ' plan->id: '.$plan->id);

            if ($subscribedPlan->id == $plan->id)
                return 'true';
        }

        return 'false';
    }

    public function completed($planWorkoutId)
    {
        $planWorkout = PlanWorkout::find($planWorkoutId);

        foreach ($planWorkout->finishers as $finisher)
            if ($finisher->id == $this->id)
                return 'true';

        return 'false';
    }

    public function completedWorkouts()
    {
        return $this->belongsToMany('App\Models\PlanWorkout','plan_workout_user', 'user_id', 'plan_workout_id')->withPivot('completed_on');
    }

}
