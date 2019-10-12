@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$plan->name}}
                    <div class="float-right">
                        @if ($plan->user_id == Auth::id())
                        <a class="btn btn-primary btn-sm" href="/plans/{{$plan->id}}/edit">
                            Edit
                        </a>
                        @endif
                        <subscribe-component :user="{{$user}}" :plan="{{$plan}}" :subscribed="{{$user->subscribed($plan)}}"></subscribe-component>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{$plan->description}}
                    
                    <hr>
                    <div class="mt-3">
                    <h3>Workouts in this plan</h3>
                    <table class="table table-sm table-striped">
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Workout</th>
                            <th>Intensity</th>
                            <th>Duration</th>
                          </tr>
                        </thead>
                         <tbody>
                            @foreach($plan->workouts as $workout)
                            <tr>
                               <td>{{ \Carbon\Carbon::parse($workout->pivot->start_on)->format('m/d/Y')}}</td>
                               <td>{{ $workout->name }}</td>
                               <td>{{ $workout->intensity }}</td>
                               <td>{{ $workout->duration }}</td>
                            </tr>
                            @endforeach
                         </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
