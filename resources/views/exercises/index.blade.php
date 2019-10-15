@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
                <div class="card-header">Available Exercist List
                </div>
            <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-sm">
                      <thead>
                     <tr>
                        <th>Exercise</th>
                        <th>Added to Workouts</th>
                        <th></th>
                     </tr>
                     </thead>
                    <tbody>
                      @foreach($exercises as $exercise)
                      <tr>
                         <td>{{ $exercise->name }}</td>
                         <td>{{ $exercise->workouts->count() }}</td>
                         <td class="text-right">
                          <form action="/exercises/{{$exercise->id}}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="submit" name="submit" value="Remove" {{ $exercise->workouts->count() > 0 ? 'disabled ' : ''}} class="btn btn-danger btn-sm" onClick="return confirm(\'Are you sure?\')">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                          </form>
                        </td>
                      </tr>
                      @endforeach
                   </tbody>
                    </table>
                    {{ $exercises->links() }}
                    <a href="/plans/create" class="btn btn-primary"  data-toggle="modal" data-target="#myModal"><i class="fas fa-plus"></i> Add Exercise</a>
            </div>
          </div>
      </div>
  </div>
  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Exercise</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        
          
        <!-- Modal body -->
        <div class="modal-body">
          <form class="form-horizontal" method="POST" action="/exercises" id="formAddExercise">
          <div class="form-group row">
            <label class="col-md-3">Exercise</label>
            <div class="col-md-9">
              <input class="form-control" type="text" name="exercise" required autofocus>
              <span class="help-block"></span>
            </div>
          </div>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="submit" form="formAddExercise" class="btn btn-primary" value="Add" />
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
        
      </div>
    </div>
  </div>
</div>
@endsection
