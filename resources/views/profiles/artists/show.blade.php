@include('base.base')
@include('base.nav')
<div class="container">
    <h1 class="d-inline-block">{{ $artist->name }}</h1><h3 class="d-inline-block text-secondary">#{{ $artist->tag }}</h3>
    @foreach($users as $user)
        @if($user->artists()->exists() && $user->id === Auth::id())
            <a href="/artists/{{ $artist->id }}/edit"><button class="d-inline-block btn btn-primary float-right">Edit</button></a>
        @endif
    @endforeach
    <hr>
    @if($artist->description != null)
    <h2>Description</h2>
        <p>{{ $artist->description }}</p>
    @endif

    @if($artist->spotify != null)
        <h2>Spotify</h2>
        <a href="{{ $artist->spotify }}"><p>{{ $artist->spotify }}</p></a>
    @endif

    @if($artist->soundcloud != null)
        <h2>Soundcloud</h2>
        <a href="{{ $artist->soundcloud }}"><p>{{ $artist->soundcloud }}</p></a>
    @endif

    @if($artist->youtube != null)
        <h2>YouTube</h2>
        <a href="{{ $artist->youtube }}"><p>{{ $artist->youtube }}</p></a>
    @endif

    @if($artist->amazon_music != null)
        <h2>YouTube</h2>
        <a href="{{ $artist->amazon_music }}"><p>{{ $artist->amazon_music }}</p></a>
    @endif

    @if($artist->apple_music != null)
        <h2>YouTube</h2>
        <a href="{{ $artist->apple_music }}"><p>{{ $artist->apple_music }}</p></a>
    @endif
    @if($artist->website != null)
    <h2>Website</h2>
        <p>{{ $artist->website }}</p>
    @endif
</div>
