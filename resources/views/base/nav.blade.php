@php use Illuminate\Support\Facades\Auth; @endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">NoWeekends</a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/events">Events</a>
            </li>
        </ul>
    @if(Auth::guest())
            <a href="/login">
                <button class="btn btn-outline-primary mr-2">Login</button>
            </a>
            <a href="/users/create">
                <button class="btn btn-primary mr-2">Register</button>
            </a>
        @else
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->username }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/logout">Logout</a>
                        <a class="dropdown-item" href="/users/{{ Auth::id() }}">Profile</a>
                    </div>
                </li>

            </ul>
        @endif
    </div>
</nav>
