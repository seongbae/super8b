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
                        <th>Focus</th>
                        <th># of Activities</th>
                        <th>Visibility</th>
                        <th></th>
                     </tr>
                     </thead>
                     <tbody>
                        @foreach($myworkouts as $workout)
                        <tr>
                           <td><a href="{{ route('workouts.show', $workout)}}">{{ $workout->name }}</a></td>
                           <td>{{ $workout->focus }}</td>
                           <td>{{ $workout->exercises()->count() }}</td>
                           <td>{{ $workout->visibility }}</td>
                           <td><a href="{{ route('workouts.edit', $workout)}}" class="btn btn-secondary btn-sm float-left mr-2"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('workouts.destroy', $workout)}}" method="POST">
                          <input type="hidden" name="_method" value="DELETE"> 
                          <button name="submit" value="Delete" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                      </td>
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
                        <th>Focus</th>
                        <th># of Activities</th>
                        <th>Visibility</th>
                        <th>Author</th>
                     </tr>
                     </thead>
                     <tbody>
                        @foreach($allworkouts as $workout)
                        <tr>
                           <td><a href="{{ route('workouts.show', $workout)}}">{{ $workout->name }}</a></td>
                           <td>{{ $workout->focus }}</td>
                           <td>{{ $workout->exercises()->count() }}</td>
                           <td>{{ $workout->visibility }}</td>
                           <td>{{ $workout->author->name }}</td>
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
