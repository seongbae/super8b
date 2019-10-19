@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Copy Plan
                    <div class="float-right">
                        
                    </div>
                </div>
                <div class="card-body">
                    <strong>Copying:</strong> {{$plan->name}}
                    <hr>
                    <form>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" placeholder="My Workout Plan" value="Copy of {{$plan->name}}" required  autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="notes" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-6">
                                <input id="notes" type="text" class="form-control" value="{{$plan->description}}" name="notes">
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
                                <input id="goals" type="text" class="form-control" value="{{$plan->goals}}" name="goals"  placeholder="pass ACFT, lose weight, etc">

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class=" offset-md-4 col-md-6">
                                <button type="submit" class="btn btn-primary ">
                                    Save
                                </button>
                                <a href=""  class="btn btn-primary ">Cancel</a>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
