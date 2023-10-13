@php use Illuminate\Support\Facades\Auth; @endphp
@include('base.base')
@include('base.nav')
<div class="container">
    <h1 class="d-inline-block">{{ $artist->name }}</h1>
    <h3 class="d-inline-block text-secondary">#{{ $artist->tag }}</h3>
    @foreach($users as $user)
        @if($user->artists()->exists() && $user->id === Auth::id())
            <a href="/artists/{{ $artist->id }}/edit">
                <button class="d-inline-block btn btn-primary float-end">Edit</button>
            </a>
        @endif
    @endforeach
    <hr>
    @if($artist->description != null)
        <h3>Description</h3>
        <p>{!! $artist->description !!}</p>
    @endif

    @if($artist->spotify != null)
        <h3>Spotify</h3>
        <a href="{{ $artist->spotify }}"><p>{{ $artist->spotify }}</p></a>
    @endif

    @if($artist->soundcloud != null)
        <h3>Soundcloud</h3>
        <a href="{{ $artist->soundcloud }}"><p>{{ $artist->soundcloud }}</p></a>
    @endif

    @if($artist->youtube != null)
        <h3>YouTube</h3>
        <a href="{{ $artist->youtube }}"><p>{{ $artist->youtube }}</p></a>
    @endif

    @if($artist->amazon_music != null)
        <h3>YouTube</h3>
        <a href="{{ $artist->amazon_music }}"><p>{{ $artist->amazon_music }}</p></a>
    @endif

    @if($artist->apple_music != null)
        <h3>YouTube</h3>
        <a href="{{ $artist->apple_music }}"><p>{{ $artist->apple_music }}</p></a>
    @endif
    @if($artist->website != null)
        <h3>Website</h3>
        <p>{{ $artist->website }}</p>
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
