@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a Workout Plan
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary btn-sm pull-right">
                            Save
                        </button>
                    </div>
                </div>
            <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <plan-component></plan-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
