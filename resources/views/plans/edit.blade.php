@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <plan-component :user-data="{{$user}}" :plan-data="{{ $plan}}"></plan-component>
        </div>
    </div>
</div>
@endsection
