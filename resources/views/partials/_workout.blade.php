<strong>Date:</strong> {{ \Carbon\Carbon::parse($workout->pivot->start_on)->format('l m/d/Y')}}</strong><br>
<strong>Workout:</strong> {{$workout->name}}<br>
@if ($workout->focus)
<strong>Focus:</strong> {{$workout->focus}}<br>
@endif
@if ($workout->pivot->location)
<strong>Location:</strong> {{$workout->pivot->location}}<br>
@endif
@if ($workout->notes)
{!! nl2br($workout->notes) !!}<br>
@endif
<div class="py-3">
  @foreach ($workout->exercises()->orderBy('sort')->get() as $exercise)
      {{Helpers::getActivityName($exercise->name, $exercise->pivot->repetition, $exercise->pivot->set)}}<br/>
  @endforeach
</div>
<div class="mb-2">
  <small class="text-muted">Part of {{ Helpers::getPlanName($workout->pivot->plan_id)}}</small>
</div>