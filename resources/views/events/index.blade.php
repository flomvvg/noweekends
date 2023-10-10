@include('base.base')
@include('base.nav')
<div class="container">
    <h1>Events</h1>
    @foreach($events as $event)
        <a style="text-decoration: none" class="link-dark p-3" href="/events/{{ $event->id }}">
            <div class="card">
                <div class="card-body row">
                    <h4>{{ $event->name }}</h4>
                    <hr>
                    <div class="col-4">
                        <p><b>Start: </b>{{ $event->start_date }}, {{ $event->start_time }}</p>
                        <p><b>End: </b>{{ $event->end_date }}, {{ $event->end_time }}</p>
                        @if($event->venue_registered)
                            <p><b>Location: </b>{{ $event->venue()->first()->name }} <br>
                                {{ $event->venue()->first()->street }} {{ $event->venue()->first()->number }}<br>
                            {{ $event->venue()->first()->zip }} {{ $event->venue()->first()->city }}</p>
                        @endif
                    </div>
                    <div class="col-4">
                        <p><b>Event Type: </b>{{ $event->weather_condition }} {{ $event->type }}</p>
                        <p><b>Genre: </b>{{ $event->genre()->first()->name }}</p>
                        <p><b>Minimum Age: </b>{{ $event->minimum_age }}</p>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
    {{ $events->links() }}
</div>

