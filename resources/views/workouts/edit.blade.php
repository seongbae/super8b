@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Workout
                    <div class="float-right">
                        
                    </div>
                </div>
            <div class="card-body">
                    <workout-component :user-data="{{$user}}" :workout-data="{{ $workout}}" :page-mode="'edit'" :plans="{{$user->plans}}"></workout-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
