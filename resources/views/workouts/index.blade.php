@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Workout 
            </div>
            <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-sm table-striped">
                     <thead>
                     <tr>
                        <th>Name</th>
                     </tr>
                     </thead>
                     <tbody>
                        @foreach($workouts as $workout)
                        <tr>
                           <td><a href="/workouts/{{$workout->id}}">{{ $workout->name }}</a></td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  {{ $workouts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
