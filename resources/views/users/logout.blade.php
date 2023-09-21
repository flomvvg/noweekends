@include('base.base')
@include('base.nav')
<div class="container">
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <br>
    <h1>Logout</h1>
    <br>
    <p>You have been logged out</p>
</div>
