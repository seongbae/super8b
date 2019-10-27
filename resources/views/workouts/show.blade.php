@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{$workout->name}}
                    <div class="float-right">
                        <div class="ml-2 dropdown show float-right" >
                          <a class="btn btn-secondary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                          </a>

                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{route('workouts.copy', $workout)}}">Copy</a>
                            @if ($workout->user_id == Auth::id())
                            <a class="dropdown-item" href="{{ route('workouts.edit', $workout)}}">
                                Edit
                            </a>
                            <form action="{{ route('workouts.destroy', $workout)}}" method="POST" id="workout_form">
                              <input type="hidden" name="_method" value="DELETE"> 
                              <a class="dropdown-item" href="#" onclick="var r = confirm('Are you sure?'); if (r) { document.getElementById('workout_form').submit(); return false;}">Delete</a>
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

                    <div class="workout-details mb-4">
                        <strong>Author:</strong> {{$workout->author->name}}<br>
                        
                        @if ($workout->focus)
                            <strong>Focus:</strong> {{$workout->focus}}<br>
                        @endif

                        @if ($workout->duration)
                            <strong>Duration:</strong> {{$workout->duration}}<br>
                        @endif

                        @if ($workout->intensity)
                            <strong>Intensity:</strong> {{$workout->intensity}}<br>
                        @endif

                        @if ($workout->notes)
                            {{$workout->notes}}<br>
                        @endif
                    </div>
                    
                    <div class="workout-exercises">
                    Exercises in this workout

                    <table class="table table-sm table-striped mt-2">
                         <tbody>
                            @foreach($workout->exercises()->orderBy('sort')->get() as $exercise)
                            <tr>
                               <td>{{ Helpers::getActivityName($exercise->name, $exercise->pivot->repetition, $exercise->pivot->set) }}</td>
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
