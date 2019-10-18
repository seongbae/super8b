@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <plan-component :user-data="{{$user}}"></plan-component>
        </div>
    </div>
</div>
@endsection
