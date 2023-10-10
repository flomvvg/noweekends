@php use Illuminate\Support\Facades\Auth; @endphp
@include('base.base')
@include('base.nav')
<div class="container">
    @if($event->cancelled)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            This Event has been cancelled
        </div>
    @endif
    <h1 class="d-inline-block">{{ $event->name }}</h1>
    @if(!Auth::guest())
        @foreach($organizer->users()->get() as $user)
            @if($user->id === Auth::id())
                <a href="/events/{{ $event->id }}/edit">
                    <button class="d-inline-block btn btn-primary float-end">Edit</button>
                </a>
            @endif
        @endforeach
    @endif
    <p><b></b>{{ $event->start_date }} at {{ $event->start_time }} - {{ $event->end_date }} at {{ $event->end_time }}</p>
    <div class="row">
        <h3>Event Info</h3>
        <hr>
        <div class="col-4">
            <p><b>Event Type: </b> {{ $event->weather_condition }} {{ $event->type }}</p>
            @if($event->venue_registered)
                <p class="m-0"><b>Venue: </b> <a href="/venues/{{ $venue->id }}">{{ $venue->name }}</a></p>
                <p class="m-0">{{ $venue->street }} {{ $venue->number }}</p>
                <p class="m-0">{{ $venue->zip }} {{ $venue->city }}</p>
            @else
                <p class="m-0"><b>Venue: </b> {{ $event->venue_name }}</p>
                <p class="m-0">{{ $event->street }} {{ $event->number }}</p>
                <p class="m-0">{{ $event->zip }} {{ $event->city }}</p>
            @endif
        </div>
        <div class="col-4">
            <p><b>Genre: </b> {{ $genre->name }}</p>
            <p><b>Minimum Age: </b>{{ $event->minimum_age }}</p>
        </div>
        <div class="col-4">
            <p><b>Presale: </b>
                @if($event->presale_available)
                    <a class="link-opacity-25-hover" target="_blank"
                       href="{{ $event->presale_link }}">{{ ucfirst(parse_url($event->presale_link)['host']) }}</a>
                @else
                    No Presale Available
                @endif</p>
            <p><b>Box Office: </b> @if($event->box_office_available)
                    {{ $event->box_office_price }} (Local Currency)
                @else
                    No Box Office Available
                @endif
            </p>
            @if (!empty($event->facebook_event))
                <p><a href="{{ $event->facebook_event }}">Facebook Event</a></p>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <h3>Description</h3>
        <hr>
        <p>{{ $event->description }}</p>
    </div>
    <br>
    <div class="row">
        <h3>Lineup</h3>
        <hr>
        @if(!empty($artists))
            @foreach($artists as $artist)
                <div class="pb-2">
                    <a href="{{ route('artists.show', $artist) }}">
                        <h4 class="d-inline">{{ $artist->name }}</h4>
                        <p class="d-inline text-black-50">#{{ $artist->tag }}</p>
                    </a>
                    @if(empty($artist->spotify) && empty($artist->soundcloud) && empty($artist->youtube) && empty($artist->amazon_music) && empty($artist->apple_music))
                        <div class="col-auto pb-2">
                            <p class="m-0">This artist has not yet provided any links...</p>
                        </div>
                    @else
                        <div class="col-auto pb-2">
                            @if(!empty($artist->spotify))
                                <a class="btn btn-light" target="_blank" href="{{ $artist->spotify }}">Spotify</a>
                            @endif
                            @if(!empty($artist->soundcloud))
                                <a class="btn btn-light" target="_blank" href="{{ $artist->soundcloud }}">Soundcloud</a>
                            @endif
                            @if(!empty($artist->youtube))
                                <a class="btn btn-light" target="_blank" href="{{ $artist->youtube }}">YouTube</a>
                            @endif
                            @if(!empty($artist->amazon_music))
                                <a class="btn btn-light" target="_blank" href="{{ $artist->amazon_music }}">Amazon Music</a>
                            @endif
                            @if(!empty($artist->apple_music))
                                <a class="btn btn-light" target="_blank" href="{{ $artist->apple_music }}">Apple Music</a>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
        @if(!empty($unregisteredArtists))
            @foreach($unregisteredArtists as $unregisteredArtist)
                <h4 class="d-inline">{{ $unregisteredArtist->name }}</h4>
                @if(empty($unregisteredArtist->spotify) && empty($unregisteredArtist->soundcloud) && empty($unregisteredArtist->youtube)
                    && empty($unregisteredArtist->amazon_music) && empty($unregisteredArtist->apple_music))
                    <div class="col-auto pb-2">
                        <p class="m-0">No links provided by the organizer...</p>
                    </div>
                @else
                    <div class="col-auto pb-2">
                        @if(!empty($unregisteredArtist->spotify))
                            <a class="btn btn-light" target="_blank" href="{{ $unregisteredArtist->spotify }}">Spotify</a>
                        @endif
                        @if(!empty($unregisteredArtist->soundcloud))
                            <a class="btn btn-light" target="_blank" href="{{ $unregisteredArtist->soundcloud }}">Soundcloud</a>
                        @endif
                        @if(!empty($unregisteredArtist->youtube))
                            <a class="btn btn-light" target="_blank" href="{{ $unregisteredArtist->youtube }}">YouTube</a>
                        @endif
                        @if(!empty($unregisteredArtist->amazon_music))
                            <a class="btn btn-light" target="_blank" href="{{ $unregisteredArtist->amazon_music }}">Amazon Music</a>
                        @endif
                        @if(!empty($unregisteredArtist->apple_music))
                            <a class="btn btn-light" target="_blank" href="{{ $unregisteredArtist->apple_music }}">Apple Music</a>
                        @endif
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
