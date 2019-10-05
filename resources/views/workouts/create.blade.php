@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                	Create Workout
                	<button type="submit" class="btn btn-primary btn-sm">
                Save
            </button>
                </div>

                <div class="card-body">
                    <workout-component></workout-component>
	            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
