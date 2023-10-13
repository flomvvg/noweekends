@php use Illuminate\Support\Facades\Auth; @endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">NoWeekends</a>
        <div class="navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/events">Events</a>
                </li>
            </ul>
        </div>
    @if(Auth::guest())
        <div class="float-end">
            <a href="/login">
                <button class="btn btn-outline-primary me-2">Login</button>
            </a>
            <a href="/users/create">
                <button class="btn btn-primary">Register</button>
            </a>
        </div>
        @else
            <ul class="navbar-nav">
                @if(!Auth::guest())
                    <a href="/events/create">
                        <button class="btn btn-outline-primary me-2">Create Event</button>
                    </a>
                @endif
                <li class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(!Auth::guest())
                            {{ Auth::user()->username }}
                        @endif
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                        <li><a class="dropdown-item" href="/users/{{ Auth::user()->id }}">Your User</a></li>
                        <li><a class="dropdown-item" href="/profiles/create">Create Profile</a></li>
                        <li><a class="dropdown-item" href="/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        @endif
        </div>
</nav>
@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="mb-5">

</div>
