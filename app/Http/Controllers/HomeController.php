<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Helpers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $todaysWorkout = collect();
        $nextWorkout = collect();

        foreach ($user->subscribedPlans as $plan)
        {
            foreach ($plan->workouts as $workout)
            {
                if ($todaysWorkout->count() > 0)
                {
                    $nextWorkout->add($workout);
                }

                if (Helpers::fallsOnToday($workout->pivot->start_on))
                {
                    $todaysWorkout->add($workout);
                }


            }
        }

        return view('home')
            ->with('user', $user)
            ->with('todaysWorkout', $todaysWorkout)
            ->with('nextWorkout', $nextWorkout);
    }
}
