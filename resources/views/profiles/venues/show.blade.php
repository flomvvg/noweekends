@include('base.base')
@include('base.nav')
<div class="container">
    <h1 class="d-inline-block">{{ $venue->name }}</h1><h3 class="d-inline-block text-secondary">#{{ $venue->tag }}</h3>
    @foreach($users as $user)
        @if($user->artists()->exists() && $user->id === Auth::id())
            <a href="/artists/{{ $venue->id }}/edit"><button class="d-inline-block btn btn-primary float-right">Edit</button></a>
        @endif
    @endforeach
    @if($venue->description != null)
        <h2>Description</h2>
        <p>{{ $venue->description }}</p>
    @endif
    <hr>
    <h2>Address</h2>
    <p>{{ $venue->street }} {{ $venue->number }}</p>
    <p>{{ $venue->zip }} {{ $venue->city }}</p>
    @if($venue->website != null)
        <h2>Website</h2>
        <p>{{ $venue->website }}</p>
    @endif
</div>
