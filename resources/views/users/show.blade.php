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
</div>
