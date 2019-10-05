@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$workout->name}}
                    <div class="float-right">
                        @if ($workout->user_id == Auth::id())
                        <a class="btn btn-primary btn-sm" href="/workouts/{{$workout->id}}/edit">
                            Edit
                        </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{$workout->description}}
                    
                    <table class="table table-sm table-striped">
                         <tbody>
                            @foreach($workout->exercises as $exercises)
                            <tr>
                               <td>{{ $exercises->name }}</td>
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
