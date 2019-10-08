@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                	Create/Edit Workout {{$user->name}}
                </div>

                <div class="card-body">
                    <workout-component :user-data="{{$user}}"></workout-component>
	            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
