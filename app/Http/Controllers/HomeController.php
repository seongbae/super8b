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
            foreach ($plan->workouts()->orderBy('start_on')->get() as $workout)
            {
                if (Helpers::fallsOnToday($workout->pivot->start_on))
                {
                    $todaysWorkout->add($workout);
                }

                if (Helpers::inFuture($workout->pivot->start_on))
                {
                    $nextWorkout->add($workout);
                }
            }
        }

        $muscle['pectoral'] = 0.8;
        $muscle['triceps'] = 0.2;

        return view('home')
            ->with('user', $user)
            ->with('todaysWorkout', $todaysWorkout)
            ->with('nextWorkout', $nextWorkout)
            ->with('muscle', $muscle);
    }

    public function showBody()
    {
        return view('body');
    }
}
