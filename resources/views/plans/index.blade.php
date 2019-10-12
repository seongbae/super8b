@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="my-plans-tab" data-toggle="tab" href="#my-plans" role="tab" aria-controls="my-plans" aria-selected="true">My Plans ({{ count($plans)}})</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="all-plans-tab" data-toggle="tab" href="#all-plans" role="tab" aria-controls="all-plans" aria-selected="false">All Plans ({{ count($plans)}})</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="subscribed-plans-tab" data-toggle="tab" href="#subscribed-plans" role="tab" aria-controls="subscribed-plans" aria-selected="false">Subscribed ({{ count($plans)}})</a>
              </li>
            </ul>
            <div class="tab-content pt-4 pl-1" id="myTabContent">
              <div class="tab-pane fade show active" id="my-plans" role="tabpanel" aria-labelledby="my-plans-tab">
                <table class="table table-sm">
                    <thead>
                     <tr>
                        <th>Plan</th>
                        <th>Goals</th>
                        <th>Duration</th>
                        <th>Author</th>
                     </tr>
                     </thead>
                 <tbody>
                    @foreach($plans as $plan)
                    <tr>
                       <td><a href="/plans/{{$plan->id}}">{{ $plan->name }}</a></td>
                       <td>{{ $plan->goals }}</td>
                       <td>{{ $plan->duration }}</td>
                       <td>{{ $plan->author->name }}</td>
                    </tr>
                    @endforeach
                 </tbody>
                  </table>
                  {{ $plans->links() }}
              </div>
              <div class="tab-pane fade" id="all-plans" role="tabpanel" aria-labelledby="all-plans-tab">
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
              <div class="tab-pane fade" id="subscribed-plans" role="tabpanel" aria-labelledby="subscribed-plans-tab">
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
