@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Workout Plans
            </div>
            <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-sm">
                     <tbody>
                        @foreach($plans as $plan)
                        <tr>
                           <td><a href="/plans/{{$plan->id}}">{{ $plan->name }}</a></td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  {{ $plans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
