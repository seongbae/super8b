@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$plan->name}}
                    <div class="float-right">
                        @if ($plan->user_id == Auth::id())
                        <a class="btn btn-primary btn-sm" href="/plans/{{$plan->id}}/edit">
                            Edit
                        </a>
                        @endif
                        <button type="submit" class="btn btn-primary btn-sm">
                            Subscribe
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{$plan->description}}
                    
                    <table class="table table-sm table-striped">
                         <tbody>
                            @foreach($plan->workouts as $workout)
                            <tr>
                               <td>{{ $workout->name }}</td>
                            </tr>
                            @endforeach
                         </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
