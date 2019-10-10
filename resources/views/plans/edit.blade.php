@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Workout Plan
                    <div class="float-right">
                        
                    </div>
                </div>
            <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <plan-component :user-data="{{$user}}" :plan-data="{{ $plan}}"></plan-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
