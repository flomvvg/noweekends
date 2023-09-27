@include('base.base')
@include('base.nav')
<div class="container">
    <h1 class="d-inline-block">{{ $organizer->name }}</h1><h3 class="d-inline-block text-secondary">#{{ $organizer->tag }}</h3>
    @foreach($users as $user)
        @if($user->organizers()->exists() && $user->id === Auth::id())
            <a href="/organizers/{{ $organizer->id }}/edit"><button class="d-inline-block btn btn-primary float-right">Edit</button></a>
        @endif
    @endforeach
    <hr>
    @if($organizer->description != null)
    <h2>Description</h2>
        <p>{{ $organizer->description }}</p>
    @endif
    @if($organizer->website != null)
    <h2>Website</h2>
        <p>{{ $organizer->website }}</p>
    @endif
</div>
