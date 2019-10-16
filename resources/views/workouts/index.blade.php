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
            <ul class="nav nav-tabs border-0 super8b-tab-menus" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active border border-bottom-0" id="home-tab" data-toggle="tab" href="#myworkouts" role="tab" aria-controls="home" aria-selected="true">My Workouts ({{ count($myworkouts)}})</a>
              </li>
              <li class="nav-item">
                <a class="nav-link border border-bottom-0" id="history-tab" data-toggle="tab" href="#allworkouts" role="tab" aria-controls="contact" aria-selected="false">All Workouts ({{ count($allworkouts)}})</a>
              </li>
            </ul>
            <div class="tab-content h-90 super8b-tabs" id="myTabContent">
              <div class="tab-pane fade show active h-100 p-3 border " id="myworkouts" role="tabpanel" aria-labelledby="home-tab">
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
                           <td><a href="/workouts/{{$workout->id}}">{{ $workout->name }}</a><br>{{ $workout->focus }}</td>
                           <td>{{ $workout->intensity }}</td>
                           <td>{{ $workout->duration }}</td>
                           <td>{{ $workout->created_at }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  {{ $myworkouts->links() }}
                  <a href="/workouts/create" class="btn btn-primary"><i class="fas fa-plus"></i> Create a Workout</a>
              </div>
              <div class="tab-pane fade h-100 p-3 border " id="allworkouts" role="tabpanel" aria-labelledby="history-tab">
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
                           <td><a href="/workouts/{{$workout->id}}">{{ $workout->name }}</a><br>{{ $workout->focus }}</td>
                           <td>{{ $workout->intensity }}</td>
                           <td>{{ $workout->duration }}</td>
                           <td>{{ $workout->author->name }}</td>
                           <td>{{ $workout->created_at }}</td>
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
