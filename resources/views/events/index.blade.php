@include('base.base')
@include('base.nav')
<div class="container">
    <h1>Events</h1>
    <div class="row">
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filters" aria-expanded="false" aria-controls="filters">
            Filter
        </button>
        <div class="collapse pt-3" id="filters">
            <div class="card card-body">
                <form action="/events" method="GET">
                    <div class="row pb-2">
                        <div class="col-2">
                            <label for="end_date">At or After:</label>
                            <input class="form-control" type="date" name="end_date" id="end_date"
                                   value="@if(!empty($filter['end_date'])) {{ $filter['end_date'] }}@endif">
                        </div>
                        <div class="col-2">
                            <label for="genre">Genre</label>
                            <input class="form-control" name="genre" id="genre" list="genreList"
                            value="@if(!empty($filter['genre'])) {{ $filter['genre'] }}@endif">
                            <datalist id="genreList">
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->name }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-2">
                            <label for="weather_condition">Weather Condition</label>
                            <select class="form-select form-control" name="weather_condition" id="weather_condition">
                                <option value="">--- Select ---</option>
                                <option value="Indoor" @if(!empty($filter['weather_condition']) && $filter['weather_condition'] == 'Indoor') selected @endif>Indoor</option>
                                <option value="Outdoor" @if(!empty($filter['weather_condition']) && $filter['weather_condition'] == 'Outdoor') selected @endif>Outdoor</option>
                                <option value="Indoor & Outdoor" @if(!empty($filter['weather_condition']) && $filter['weather_condition'] == 'Indoor & Outdoor') selected @endif>Indoor & Outdoor</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="type">Type</label>
                            <select class="form-select form-control" id="type" name="type">
                                <option value="">--- Select ---</option>
                                <option value="Party" @if(!empty($filter['type']) && $filter['type'] == 'Party') selected @endif>Party</option>
                                <option value="Festival" @if(!empty($filter['type']) && $filter['type'] == 'Festival') selected @endif>Festival</option>
                                <option value="Daydance" @if(!empty($filter['type']) && $filter['type'] == 'Daydance') selected @endif>Daydance</option>
                                <option value="Concert" @if(!empty($filter['type']) && $filter['type'] == 'Concert') selected @endif>Concert</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="city">City</label>
                            <input class="form-control" type="text" name="city" id="city"
                                   value="@if(!empty($filter['city'])) {{ $filter['city'] }}@endif">
                        </div>
                    </div>
                    <div class="row col-auto pb-2">
                        <div class="form-group col-1">
                            <label for="minimum_age">Age From</label>
                            <input min="0" class="form-control" type="number" name="minimum_age" id="minimum_age"
                            value="@if(!empty($filter['minimum_age'])) {{ $filter['minimum_age'] }}@endif">
                        </div>
                        <div class="col-1">
                            <label for="minimum_age_sm">Age To</label>
                            <input min="0" class="form-control" type="number" name="minimum_age_sm" id="minimum_age_sm"
                            value="@if(!empty($filter['minimum_age_sm'])) {{ $filter['minimum_age_sm'] }}@endif">
                        </div>
                        <div class="col-2">
                            <label for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-control"
                            value="@if(!empty($filter['search'])) {{ $filter['search'] }}@endif">
                        </div>
                        <div class="col-2">
                            <label for="artist">Artist</label>
                            <input class="form-control" name="artist" id="artist" list="artistList"
                            value="@if(!empty($filter['artist'])) {{ $filter['artist'] }}@endif">
                            <datalist id="artistList">
                                @foreach($artists as $artist)
                                    @if(!$artist->archived)
                                        <option value="{{ $artist->name }}#{{$artist->tag}}"></option>
                                    @endif
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <br>
                    <input class="btn btn-primary" type="submit" name="submit" id="submit" value="Run">
                    <a href="/events" class="btn btn-danger">Clear Filters</a>
                </form>
            </div>
        </div>
    </div>
    @if(!$events->isEmpty())
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
                            @else
                                <p><b>Location: </b>{{ $event->venue_name }} <br>
                                    {{ $event->street }} {{ $event->number }}<br>
                                    {{ $event->zip }} {{ $event->city }}</p>
                            @endif
                        </div>
                        <div class="col-4">
                            <p><b>Event Type: </b>{{ $event->weather_condition }} {{ $event->type }}</p>
                            <p><b>Genre: </b>{{ $event->genre()->first()->name }}</p>
                            <p><b>Minimum Age: </b>{{ $event->minimum_age }}</p>
                        </div>
                        <div class="col-4">
                            <p><b>Organizer: </b>{{ $event->organizerProfile()->name }}</p>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    @else
        <p class="pt-4">No events found...</p>
    @endif

    <div class="row">
        {{ $events->links('pagination::bootstrap-5') }}

    </div>

</div>

