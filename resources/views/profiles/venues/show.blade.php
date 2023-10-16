@include('base.base')
@include('base.nav')
<div class="container">
    <h1 class="d-inline-block">{{ $venue->name }}</h1><h3 class="d-inline-block text-secondary">#{{ $venue->tag }}</h3>
    @foreach($users as $user)
        @if($user->venues()->exists() && $user->id === Auth::id())
            <a href="/venues/{{ $venue->id }}/edit"><button class="d-inline-block btn btn-primary float-end">Edit</button></a>
        @endif
    @endforeach
    @if($venue->description != null)
        <h2>Description</h2>
        <p>{!! $venue->description !!}</p>
    @endif
    <hr>
    <h2>Address</h2>
    <p>{{ $venue->street }} {{ $venue->number }}</p>
    <p>{{ $venue->zip }} {{ $venue->city }}</p>
    @if($venue->website != null)
        <h2>Website</h2>
        <p>{{ $venue->website }}</p>
    @endif
    <h2>Upcoming Events</h2>
    <hr>
    @if(!$upcomingEvents->isEmpty())
        @foreach($upcomingEvents as $upcomingEvent)
            <div class="row pb-2">
                <h3><a href="/events/{{ $upcomingEvent->id }}">{{ $upcomingEvent->name }}</a></h3>
                <div class="col-4">
                    <p class="m-0"><b>Start: </b>{{ $upcomingEvent->start_date }}, {{ $upcomingEvent->start_time }}</p>
                    <p class="m-0"><b>End: </b> {{ $upcomingEvent->end_date }}, {{ $upcomingEvent->end_time }}</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><b>Type: </b>{{ $upcomingEvent->weather_condition }} {{ $upcomingEvent->type }}</p>
                    <p class="m-0"><b>Genre: </b>{{ $upcomingEvent->genre()->first()->name }}</p>
                </div>
            </div>
        @endforeach
    @else
        <p>No upcoming Events...</p>
    @endif
    <hr>
    <h2>Past Events</h2>
    <hr>
    @if(!$pastEvents->isEmpty())
        @foreach($pastEvents as $pastEvent)
            <div class="row pb-2">
                <h3><a href="/events/{{ $pastEvent->id }}">{{ $pastEvent->name }}</a></h3>
                <div class="col-4">
                    <p class="m-0"><b>Start: </b>{{ $pastEvent->start_date }}, {{ $pastEvent->start_time }}</p>
                    <p class="m-0"><b>End: </b> {{ $pastEvent->end_date }}, {{ $pastEvent->end_time }}</p>
                </div>
                <div class="col-4">
                    <p class="m-0"><b>Type: </b>{{ $pastEvent->weather_condition }} {{ $pastEvent->type }}</p>
                    <p class="m-0"><b>Genre: </b>{{ $pastEvent->genre()->first()->name }}</p>
                </div>
            </div>
        @endforeach
    @else
        <p>No past Events...</p>
    @endif
</div>
