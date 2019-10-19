@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$workout->name}}
                    <div class="float-right">
                        @if ($workout->user_id == Auth::id())
                        <a class="btn btn-primary btn-sm" href="{{ route('workouts.edit', $workout)}}">
                            Edit
                        </a>
                        @endif
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

                        @if ($workout->note)
                            <strong>Note:</strong> {{$workout->note}}<br>
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
