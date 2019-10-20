@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$plan->name}}
                    <div class="float-right">
                        @if ($plan->status == 'published')
                        <subscribe-component :user="{{$user}}" :plan="{{$plan}}" :subscribed="'{{$user->subscribed($plan)}}'"></subscribe-component>
                        @endif
                        <div class="ml-2 dropdown show float-right" >
                          <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menus
                          </a>

                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{route('clone.show', $plan)}}">Clone</a>
                            @if ($plan->user_id == Auth::id())
                            <a class="dropdown-item" href="{{route('plans.edit', $plan)}}">
                                Edit
                            </a>
                            <form action="{{ route('plans.destroy', $plan)}}" method="POST" class="dropdown-item">
                              <input type="hidden" name="_method" value="DELETE"> 
                              <button name="submit" value="Delete" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                            @endif
                          </div>
                        </div>
                        
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
                    <plan-workout :workouts="{{$plan->workouts()->orderBy('start_on')->get()}}" :workoutlookups="{{json_encode($workouts)}}"></plan-workout>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
