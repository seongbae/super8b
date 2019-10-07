@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Today's Workout
            </div>
            <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

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
            </div>
        </div>
    </div>
</div>
@endsection
