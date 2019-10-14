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
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#myworkouts" role="tab" aria-controls="home" aria-selected="true">My Workouts ({{ count($myworkouts)}})</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="history-tab" data-toggle="tab" href="#allworkouts" role="tab" aria-controls="contact" aria-selected="false">All Workouts ({{ count($allworkouts)}})</a>
              </li>
            </ul>
            <div class="tab-content pt-4 pl-1" id="myTabContent">
              <div class="tab-pane fade show active" id="myworkouts" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-sm">
                     <thead>
                     <tr>
                        <th>Workout</th>
                        <th>Intensity</th>
                        <th>Duration</th>
                        <th>Created</th>
                     </tr>
                     </thead>
                     <tbody>
                        @foreach($myworkouts as $workout)
                        <tr>
                           <td><a href="/workouts/{{$workout->id}}">{{ $workout->name }}</a></td>
                           <td>{{ $workout->intensity }}</td>
                           <td>{{ $workout->duration }}</td>
                           <td>{{ $workout->author->name }}</td>
                           <td>{{ $workout->created }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  {{ $myworkouts->links() }}
                  <a href="/workouts/create" class="btn btn-primary"><i class="fas fa-plus"></i> Create a Workout</a>
              </div>
              <div class="tab-pane fade" id="allworkouts" role="tabpanel" aria-labelledby="history-tab">
                  <table class="table table-sm">
                     <thead>
                     <tr>
                        <th>Workout</th>
                        <th>Intensity</th>
                        <th>Duration</th>
                        <th>Author</th>
                        <th>Created</th>
                     </tr>
                     </thead>
                     <tbody>
                        @foreach($allworkouts as $workout)
                        <tr>
                           <td><a href="/workouts/{{$workout->id}}">{{ $workout->name }}</a></td>
                           <td>{{ $workout->intensity }}</td>
                           <td>{{ $workout->duration }}</td>
                           <td>{{ $workout->author->name }}</td>
                           <td>{{ $workout->created }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  {{ $allworkouts->links() }}
              </div>
          </div>
        </div>
    </div>
</div>
@endsection
