@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
             @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#todaysworkout" role="tab" aria-controls="home" aria-selected="true">Today's Workout</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="contact" aria-selected="false">My Workout History</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="contact" aria-selected="false">Subscribed</a>
              </li>
            </ul>
            <div class="tab-content pt-2 pl-1" id="myTabContent">
              <div class="tab-pane fade show active" id="todaysworkout" role="tabpanel" aria-labelledby="home-tab">
                 
                @if (count($todaysWorkout) > 0)
                    @foreach ($todaysWorkout as $workout)

                        

                        {{$workout->name}}<br>
                        @foreach ($workout->exercises as $exercise)
                            {{$exercise->name}}<br/>
                        @endforeach

                        {{ Helpers::getPlanName($workout->pivot->plan_id)}}<br>

                        <mark-complete-component :user="{{$user}}" :planworkoutid="{{$workout->pivot->id}}" :completed="{{$user->completed($workout->pivot->id)}}"></mark-complete-component>


                        <hr>


                    @endforeach
                @endif
              </div>
              <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                  @if (count($user->completedWorkouts) > 0)
                    @foreach ($user->completedWorkouts as $workout)
                        {{$workout->pivot->completed_on}}<br>
                    @endforeach
                @endif
              </div>
          </div>
        </div>
    </div>
</div>
@endsection
