@include('base.base')
@include('base.nav')
<div class="container">
    <br>
    <h1 class="d-inline-block">{{ $user->username }}</h1>
    <a href="/users/{{ $user->id }}/edit">
        <button type="button" class="btn btn-primary float-right">Edit</button>
    </a>
    <br>
    <p>Username: {{ $user->username }}</p>
    <p>E-Mail Address: {{ $user->email }}</p>
    <p>Joined at: {{ $user->created_at }}</p>
    <hr>
    <h2>Organizer Profiles</h2>
    <div class="list-group">
        @foreach($organizers as $organizer)
            @if(!$organizer->archived)
                <a href="/organizers/{{ $organizer->id }}" class="list-group-item list-group-item-action">{{ $organizer->name }}</a>
            @endif
        @endforeach
    </div>
    <hr>
    <h2>Artist Profiles</h2>
    <div class="list-group">
        @foreach($artists as $artist)
            @if(!$artist->archived)
                <a href="/artists/{{ $artist->id }}" class="list-group-item list-group-item-action">{{ $artist->name }}</a>
            @endif
        @endforeach
    </div>
    <hr>
    <h2>Venue Profiles</h2>
    <div class="list-group">
        @foreach($venues as $venue)
            @if(!$venue->archived)
                <a href="/venues/{{ $venue->id }}" class="list-group-item list-group-item-action">{{ $venue->name }}</a>
            @endif
        @endforeach
    </div>
</div>
