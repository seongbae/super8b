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
                <a class="nav-link border border-bottom-0" id="history-tab" data-toggle="tab" href="#next-workout" role="tab" aria-controls="contact" aria-selected="false">Coming up</a>
              </li>
            </ul>
            <div class="tab-content h-90 super8b-tabs" id="home-workout-tabs">
              <div class="tab-pane h-100 p-3 border active" id="todays-workout" role="tabpanel" aria-labelledby="todays-workout-tab">
                 
                @if (count($user->subscribedPlans) == 0)
                  You are not subscribed to any workout plans. Click <a href="/plans">here</a> to find one.
                @else
                  @if (count($todaysWorkout) > 0)
                      @foreach ($todaysWorkout as $workout)
                        <strong>{{ \Carbon\Carbon::parse($workout->pivot->start_on)->format('l m/d/Y')}}</strong><br>
                        <strong>Workout:</strong> {{$workout->name}}<br>
                        @if ($workout->pivot->location)
                        <strong>Location:</strong> {{$workout->pivot->location}}<br>
                        @endif
                        <div class="py-3">
                          @foreach ($workout->exercises as $exercise)
                              {{Helpers::getActivityName($exercise->name, $exercise->pivot->repetition, $exercise->pivot->set)}}<br/>
                          @endforeach
                        </div>
                          <div class="mb-2">
                            <small class="text-muted">Part of <a href="/plans/{{$workout->pivot->plan_id}}">{{ Helpers::getPlanName($workout->pivot->plan_id)}}</a></small>
                          </div>


                          <mark-complete-component :user="{{$user}}" :planworkoutid="{{$workout->pivot->id}}" :completed="{{$user->completed($workout->pivot->id)}}"></mark-complete-component>
                      @endforeach
                  @else
                    There's none!
                  @endif
                @endif
                

                
              </div>
              <div class="tab-pane h-100 p-3 border" id="next-workout" role="tabpanel" aria-labelledby="next-workout-tab">
                  @if (count($nextWorkout) > 0)
                    <div class="mt-2">
                      @foreach ($nextWorkout as $workout)
                        <strong>{{ \Carbon\Carbon::parse($workout->pivot->start_on)->format('l m/d/Y')}}</strong><br>
                        <strong>Workout:</strong> {{$workout->name}}<br>
                          @foreach ($workout->exercises as $exercise)
                              {{Helpers::getActivityName($exercise->name, $exercise->pivot->repetition, $exercise->pivot->set)}}<br/>
                          @endforeach

                          <div class="mt-2">
                            <small class="text-muted">part of <a href="/plans/{{$workout->pivot->plan_id}}">{{ Helpers::getPlanName($workout->pivot->plan_id)}}</a></small>
                          </div>
                          <hr>
                      @endforeach
                      </div>
                  @else
                    There's none!
                  @endif
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
