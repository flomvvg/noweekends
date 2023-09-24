@include('base.base')
@include('base.nav')
<div class="container">
    <h1 class="d-inline-block">{{ $organizer->name }}</h1><h3 class="d-inline-block text-secondary">#{{ $organizer->tag }}</h3>
    @foreach($users as $user)
        @if($user->organizers()->exists() && $user->id === Auth::id())
            <a href="/organizers/{{ $organizer->id }}/edit"><button class="d-inline-block btn btn-primary float-right">Edit</button></a>
        @endif
    @endforeach
    <h2>Description</h2>
    @if($organizer->description == null)
        <p>This organizer has not yet provided a description...</p>
    @endif
    <p>{{ $organizer->description }}</p>
    <h2>Website</h2>
    @if($organizer->website == null)
        <p>This organizer has not yet provided a website...</p>
    @endif
    <p>{{ $organizer->website }}</p>
</div>
