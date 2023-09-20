@include('base.base')
@include('base.nav')
<div class="container">
    <br>
    <h1>{{ $user->username }}</h1>
    <br>
    <p>Username: {{ $user->username }}</p>
    <p>E-Mail Address: {{ $user->email }}</p>
    <p>Joined at: {{ $user->created_at }}</p>
</div>
