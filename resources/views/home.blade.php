@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
             @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <ul class="nav nav-tabs border-0 super8b-tab-menus" id="home-tab-menus" role="tablist">
              <li class="nav-item">
                <a class="nav-link active border border-bottom-0" id="todays-workout-tab" data-toggle="tab" href="#todays-workout" role="tab" aria-controls="home" aria-selected="true">Today's Workout</a>
              </li>
              <li class="nav-item">
                <a class="nav-link border border-bottom-0" id="next-workouts-tab" data-toggle="tab" href="#next-workout" role="tab" aria-controls="contact" aria-selected="false">Coming up</a>
              </li>
              <li class="nav-item">
                <a class="nav-link border border-bottom-0" id="completed-workouts-tab" data-toggle="tab" href="#completed-workouts" role="tab" aria-controls="contact" aria-selected="false">Completed</a>
              </li>
            </ul>
            <div class="tab-content h-90 super8b-tabs" id="home-workout-tabs">
              <div class="tab-pane h-100 p-3 border active" id="todays-workout" role="tabpanel" aria-labelledby="todays-workout-tab">
                 
                @if (count($user->subscribedPlans) == 0)
                  You are not subscribed to any workout plans. Click <a href="/plans">here</a> to find one.
                @else
                  @if (count($todaysWorkout) > 0)
                      @foreach ($todaysWorkout as $workout)
                          @include('partials._workout')
                          <mark-complete-component :user="{{$user}}" :planworkoutid="{{$workout->pivot->id}}" :completed="{{$user->completed($workout->pivot->id)}}" :timezone="'{{config('app.server_timezone')}}'"></mark-complete-component>
                          @if (count($todaysWorkout) > 1)
                        <hr>
                      @endif
                      @endforeach
                  @else
                    There's none!
                  @endif
                @endif
                

                
              </div>
              <div class="tab-pane h-100 p-3 border" id="next-workout" role="tabpanel" aria-labelledby="next-workouts-tab">
                  @if (count($nextWorkout) > 0)
                    <div class="mt-2">
                      @foreach ($nextWorkout as $workout)
                        @include('partials._workout')
                          <hr>
                      @endforeach
                      </div>
                  @else
                    There's none!
                  @endif
              </div>
              <div class="tab-pane h-100 p-3 border" id="completed-workouts" role="tabpanel" aria-labelledby="completed-workouts-tab">
                <div class="row">
                  @if (App::environment('local')) 
                  <div class="col-md-6 text-center">
                    @include('partials._body', ['muscle' => $muscle])
                  </div>
                  @endif
                  <div class="col-md-6">
                    @if (count($user->completedWorkouts) > 0)
                      <div class="mt-2">
                        @foreach ($user->completedWorkouts as $planWorkoutUser)
                            <a href="{{route('workouts.show',$planWorkoutUser->planWorkout->workout)}}">{{$planWorkoutUser->planWorkout->workout->name}}</a>  - completed on {{Helpers::getLocalDateTime($planWorkoutUser->completed_on, $user->timezone)}}
                            <br>
                            <!-- [<small class="text-muted"><a href="{{ route('plans.show', $planWorkoutUser->planWorkout->plan)}}">{{$planWorkoutUser->planWorkout->plan->name}}</a></small>] -->
                        @endforeach
                        </div>
                    @else
                      There's none!
                    @endif
                  </div>
                </div>
              </div>
              <!-- <div class="tab-pane fade" id="subscribe" role="tabpanel" aria-labelledby="subscribe-tab">
                  @if (count($user->subscribedPlans) > 0)
                    @foreach ($user->subscribedPlans as $plan)
                        <a href="/plans/{{$plan->id}}">{{$plan->name}}</a><br>
                    @endforeach
                  @endif
              </div> -->
          </div>
        </div>
    </div>
</div>
@endsection
