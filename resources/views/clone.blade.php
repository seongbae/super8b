@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="far fa-copy"></i> Copy Plan
                    <div class="float-right">
                        
                    </div>
                </div>
                <div class="card-body">
                    <strong>Name:</strong> {{$plan->name}}<br>
                    <strong>Description:</strong> {{$plan->description}}<br>
                    <strong>Goals:</strong> {{$plan->goals}}<br>
                    <strong>Workouts:</strong> {{$plan->workouts()->count()}}<br>
                    <hr>
                    <form action="/clone" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" placeholder="My Workout Plan" value="Copy of {{$plan->name}}" required  autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" value="{{$plan->description}}" name="description">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="goals" class="col-md-4 col-form-label text-md-right">Goal(s):</label>

                            <div class="col-md-6">
                                <input id="goals" type="text" class="form-control" value="{{$plan->goals}}" name="goals"  placeholder="pass ACFT, lose weight, etc">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="goals" class="col-md-4 col-form-label text-md-right">Start on:</label>

                            <div class="col-md-6">
                                <input id="start_date" type="date" class="form-control" value="{{Carbon\Carbon::now()->addDays(7)->format('Y-m-d')}}" required name="start_date" >

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class=" offset-md-4 col-md-6">
                              <input type="hidden" name="plan_id" value="{{$plan->id}}">
                                <button type="submit" class="btn btn-primary ">
                                    Copy
                                </button>
                                <a href="{{URL::previous()}}"  class="btn btn-primary ">Cancel</a>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
