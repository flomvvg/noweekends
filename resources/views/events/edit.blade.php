@php use App\Models\User;use App\Models\Venue; @endphp
@include('base.base')
@include('base.nav')
<div class="container">
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endforeach
    @endif
    <h1>Create Event</h1>
    <form class="d-inline" action="/events/{{ $event->id }}" method="POST">
        @csrf @method('PATCH')
        <hr>
        <h2>Event Info</h2>
        <div class="col-auto row">
            <div class="form-group">
                <label for="name">Name</label><span class="text-danger"> *</span>
                <input class="form-control" type="text" name="name" id="name"
                       value="@if(old('name') != null){{ old('name') }}@else{{ $event->name }}@endif"/>
            </div>
        </div>
        <br>
        <div class="col-auto row">
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" cols="30"
                          rows="10">@if(old('description') != null){{ old('description') }}@else{{ $event->description }}@endif</textarea>
            </div>
        </div>
        <br>
        <div class="col-auto row">
            <div class="form-group">
                <label for="type">Type</label><span class="text-danger"> *</span>
                <select class="form-select form-control" id="type" name="type">
                    <option value="">--- Select ---</option>
                    <option value="Party" @if(old('Indoor') != null){{ old('Indoor') }}@else selected @endif>Party
                    </option>
                    <option value="Festival" @if(old('Festival') != null){{ old('Festival') }}@else selected @endif>
                        Festival
                    </option>
                    <option value="Daydance" @if(old('Daydance') != null){{ old('Daydance') }}@else selected @endif>
                        Daydance
                    </option>
                    <option value="Concert" @if(old('Concert') != null){{ old('Concert') }}@else selected @endif>
                        Concert
                    </option>
                </select>
            </div>
        </div>
        <br>
        <div class="col-auto row">
            <div class="form-group">
                <label for="weather_condition">Weather Condition</label><span class="text-danger"> *</span>
                <select class="form-select form-control" name="weather_condition" id="weather_condition">
                    <option value="">--- Select ---</option>
                    <option value="Indoor" @if(old('Indoor') != null){{ old('Indoor') }}@else selected @endif>Indoor
                    </option>
                    <option value="Outdoor" @if(old('Outdoor') != null){{ old('Outdoor') }}@else selected @endif>
                        Outdoor
                    </option>
                    <option value="Indoor & Outdoor"
                            @if(old('Indoor & Outdoor') != null){{ old('Indoor & Outdoor') }}@else selected @endif>
                        Indoor & Outdoor
                    </option>
                </select>
            </div>
        </div>
        <br>
        <div class="col-auto row">
            <div class="form-group col-8">
                <label for="start_date">Start Date</label><span class="text-danger"> *</span>
                <input class="form-control" type="date" name="start_date" id="start_date"
                       value="@if(old('start_date') != null){{ old('start_date') }}@else{{ $event->start_date }}@endif">
            </div>
            <div class="form-group col-4">
                <label for="start_time">Start Time</label><span class="text-danger"> *</span>
                <input class="form-control" type="time" name="start_time" id="start_time"
                       value="@if(old('start_time') != null){{ old('start_time') }}@else{{ $event->start_time }}@endif">
            </div>
        </div>
        <br>
        <div class="col-auto row">
            <div class="form-group col-8">
                <label for="end_date">End Date</label><span class="text-danger"> *</span>
                <input class="form-control" type="date" name="end_date" id="end_date"
                       value="@if(old('end_date') != null){{ old('end_date') }}@else{{ $event->end_date }}@endif">
            </div>
            <div class="form-group col-4">
                <label for="end_time">End Time</label><span class="text-danger"> *</span>
                <input class="form-control" type="time" name="end_time" id="end_time"
                       value="@if(old('end_time') != null){{ old('end_time') }}@else{{ $event->end_time }}@endif">
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="genre">Genre</label><span class="text-danger"> *</span>
            <input class="form-control" name="genre" id="genre" list="genreList"
                   value="@if(old('genre') != null){{ old('genre') }}@else{{ $event->genre()->first()->name }}@endif">
            <datalist id="genreList">
                @foreach($genres as $genre)
                    <option value="{{ $genre->name }}"></option>
                @endforeach
            </datalist>
        </div>
        <br>
        <div class="form-group">
            <label for="minimum_age">Minimum Age</label><span class="text-danger"> *</span>
            <input class="form-control" type="number" min="0" name="minimum_age" id="minimum_age"
                   value="@if(old('minimum_age') != null){{ old('minimum_age') }}@else{{ $event->minimum_age }}@endif">
            <div id="minimum_age_help" class="form-text">0 = All Ages</div>
        </div>
        <br>
        <br>
        <div class="form-group">
            <div class="form-check form-switch">
                <label for="presale_available">Presale Available?</label><span class="text-danger"> *</span>
                <input onchange="changeReadOnly([
                    'presale_link_label',
                    'presale_link'
                ])" class="form-check-input" type="checkbox" name="presale_available" id="presale_available"
                       @if ($event->presale_available) checked @endif>
                <div id="presale_available_help" class="form-text">Can visitors buy tickets in advance?</div>
            </div>
        </div>
        <br>
        <div class="form-group">
            <label id="presale_link_label" for="presale_link">Presale Link</label>
            <input class="form-control" type="text" name="presale_link" id="presale_link"
                   @if(old('presale_link') === null && $event->presale_link === null)
                       readonly
                   @else
                       value="@if(old('presale_link') != null){{ old('presale_link') }}@else{{ $event->presale_link }}@endif"
                @endif>
        </div>
        <br>
        <div class="form-group">
            <div class="form-check form-switch">
                <label for="box_office_available">Box Office Available?</label><span class="text-danger"> *</span>
                <input onchange="changeReadOnly([
                    'box_office_price',
                    'box_office_price_label'
                    ])" class="form-check-input" type="checkbox" name="box_office_available" id="box_office_available"
                       @if ($event->box_office_available) checked @endif>
                <div id="box_office_help" class="form-text">Can visitors buy tickets at the entrance?</div>
            </div>
        </div>
        <br>
        <div class="form-group">
            <label id="box_office_price_label" for="box_office_price">Box Office Price</label>
            <input class="form-control" type="number" name="box_office_price" id="box_office_price"
                   @if(old('box_office_available') !== "on" && !$event->box_office_available)
                       readonly
                   @else
                       value="@if(old('box_office_available') != null){{ old('box_office_price') }}@else{{ $event->box_office_price }}@endif">
            @endif
        </div>
        <br>
        <div class="form-group">
            <div class="form-check form-switch">
                <label for="oneway">One Way Entry?</label><span class="text-danger"> *</span>
                <input class="form-check-input" type="checkbox" name="oneway" id="oneway"
                       @if(old('oneway') === "on" || $event->oneway) checked @endif>
                <div id="onewayHelpOn" class="form-text">On: If visitors leave, they have to pay again to re-enter the
                    venue.
                </div>
                <div id="onewayHelpOff" class="form-text">Off: visitors can leave the whole venue (including outdoor
                    area) and re-enter the venue.
                </div>
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="facebook_event">Facebook Event</label>
            <input class="form-control" type="text" name="facebook_event" id="facebook_event"
                   value="@if(old('facebook_event') != null){{ old('facebook_event') }}@else{{ $event->facebook_event }}@endif">
        </div>
        <br>
        <div class="col-auto row">
            <label for="organizer_profile_tag">Organizer (Tag)</label>
            <div class="input-group">
                <input class="form-control" name="organizer_profile_tag" id="organizer_profile_tag" list="organizerList"
                       value="@if(old('organizer_profile_tag') != null){{ old('organizer_profile_tag') }}@else{{ $eventOrganizer->tag }}@endif">
                <datalist id="organizerList">
                    @foreach($userProfiles as $userProfile)
                        @if(!$userProfile->archived)
                            <option value="{{ $userProfile->tag }}">{{ $userProfile->name }}
                                #{{ $userProfile->tag }}</option>
                        @endif
                    @endforeach
                </datalist>
                <button id="organizer_set_button" class="btn btn-success"
                        onclick="fillOrganizer({{ json_encode($userProfiles) }})"
                        type="button">Set
                </button>
            </div>
        </div>
        <br>
        <div class="col-auto row">
            <div class="form-group">
                <label for="organizer_name">Name</label>
                <input type="text" class="form-control" name="organizer_name" id="organizer_name" disabled
                       value="@if(old('organizer_profile_tag') != null){{ old('organizer_profile_tag') }}@else{{ $eventOrganizer->name }}@endif">
            </div>
        </div>
        <br>
        <hr>
        <h2>Location Info</h2>
        <div class="row">
            <div class="form-group">
                <div class="form-check form-switch">
                    <label for="venue_registered">Venue Registered?</label>
                    <input onchange="changeReadOnly([
                    'venue_name',
                    'venue_street',
                    'venue_number',
                    'venue_zip',
                    'venue_city',
                    'venue_set_button'
                    ]); changeDisabled('venue')" class="form-check-input" type="checkbox" name="venue_registered"
                           id="venue_registered" @if($event->venue_registered) checked @endif>
                </div>
            </div>
        </div>
        <br>
        <div class="col-auto row">
            <label for="venue">Venue (Tag)</label>
            <div class="input-group">
                <input class="form-control" name="venue" id="venue" list="venueList"
                       @if ($event->venue_registered)
                           value="@if(old('venue') != null){{ old('venue') }}@else{{ Venue::find($event->venue_id)->tag }}@endif"
                       @else
                           disabled
                    @endif
                >
                <datalist id="venueList">
                    @foreach($venues as $venue)
                        @if(!$venue->archived)
                            <option value="{{ $venue->tag }}">{{ $venue->name }}#{{ $venue->tag }}</option>
                        @endif
                    @endforeach
                </datalist>
                <button id="venue_set_button" class="btn btn-success" onclick="fillVenue({{ json_encode($venues) }})"
                        type="button">Set
                </button>
            </div>
        </div>
        <br>
        <div class="form-group">
            <label for="venue_name">Name</label>
            <input class="form-control" type="text" name="venue_name" id="venue_name"
                   @if($event->venue_registered)
                       value="@if(old('venue') != null){{ old('venue') }}@else{{ Venue::find($event->venue_id)->name }}@endif"
                   readonly
                   @else
                       value="@if(old('venue') != null){{ old('venue') }}@else{{ $event->venue_name }}@endif"
                @endif
            >
        </div>
        <br>
        <div class="col-auto row">
            <div class="form-group col-10">
                <label for="venue_street">Street</label>
                <input class="form-control" type="text" name="venue_street" id="venue_street"
                       @if($event->venue_registered)
                           value="@if(old('venue_street') != null){{ old('venue_street') }}@else{{ Venue::find($event->venue_id)->street }}@endif"
                       readonly
                       @else
                           value="@if(old('venue_street') != null){{ old('venue_street') }}@else{{ $event->street }}@endif"
                    @endif
                >
            </div>
            <div class="form-group col-2">
                <label for="venue_number">Number</label>
                <input class="form-control" type="text" name="venue_number" id="venue_number"
                       @if($event->venue_registered)
                           value="@if(old('venue_number') != null){{ old('venue_number') }}@else{{ Venue::find($event->venue_id)->number }}@endif"
                       readonly
                       @else
                           value="@if(old('venue_number') != null){{ old('venue_number') }}@else{{ $event->number }}@endif"
                    @endif
                >
            </div>
        </div>
        <br>
        <div class="col-auto row">
            <div class="form-group col-2">
                <label for="venue_zip">ZIP</label>
                <input class="form-control" type="number" name="venue_zip" id="venue_zip"
                       @if($event->venue_registered)
                           value="@if(old('venue_zip') != null){{ old('venue_zip') }}@else{{ Venue::find($event->venue_id)->zip }}@endif"
                       readonly
                       @else
                           value="@if(old('venue_zip') != null){{ old('venue_zip') }}@else{{ $event->zip }}@endif"
                    @endif
                >
            </div>
            <br>
            <div class="form-group col-10">
                <label for="venue_city">City</label><span class="text-danger"> *</span>
                <input class="form-control" type="text" name="venue_city" id="venue_city"
                       @if($event->venue_registered)
                           value="@if(old('venue_city') != null){{ old('venue_city') }}@else{{ Venue::find($event->venue_id)->city }}@endif"
                       readonly
                       @else
                           value="@if(old('venue_city') != null){{ old('venue_city') }}@else{{ $event->city }}@endif"
                    @endif
                >
                <div id="onewayHelpOn" class="form-text">Only required if venue is not registered</div>
            </div>
        </div>
        <br>
        <hr>
        <h2>Lineup</h2>
        <div id="registered_artist_input_div">
            <div class="col-auto row">
                <label for="registered_artist">Registered Artist</label>
                <div class="input-group">
                    <input class="form-control" name="registered_artist" id="registered_artist"
                           list="registered_artistList">
                    <datalist id="registered_artistList">
                        @foreach($artists as $artist)
                            @if(!$artist->archived)
                                <option value="{{ $artist->name }}#{{ $artist->tag }}"></option>
                            @endif
                        @endforeach
                    </datalist>
                    <button id="venue_set_button" class="btn btn-success" onclick="addRegisteredArtist()"
                            type="button">Add
                    </button>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <div id="unregistered_artist_input_div">
            <div class="col-auto row">
                <label for="unregistered_artist">Unregistered Artist</label>
                <div class="input-group">
                    <input class="form-control" name="unregistered_artist" id="unregistered_artist">
                    <button id="venue_set_button" class="btn btn-success" onclick="addUnregisteredArtist()"
                            type="button">Add
                    </button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group col-6">
                    <label for="unregistered_artist_spotify">Spotify</label>
                    <input class="form-control" name="unregistered_artist_spotify" id="unregistered_artist_spotify">
                </div>
                <div class="form-group col-6">
                    <label for="unregistered_artist_soundcloud">Soundcloud</label>
                    <input class="form-control" name="unregistered_artist_soundcloud"
                           id="unregistered_artist_soundcloud">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group col-4">
                    <label for="unregistered_artist_youtube">YouTube</label>
                    <input class="form-control" name="unregistered_artist_youtube" id="unregistered_artist_youtube">
                </div>
                <div class="form-group col-4">
                    <label for="unregistered_artist_amazon_music">Amazon Music</label>
                    <input class="form-control" name="unregistered_artist_amazon_music"
                           id="unregistered_artist_amazon_music">
                </div>
                <div class="form-group col-4">
                    <label for="unregistered_artist_apple_music">Apple Music</label>
                    <input class="form-control" name="unregistered_artist_apple_music"
                           id="unregistered_artist_apple_music">
                </div>
            </div>
        </div>
        <br>
        <h4>Added Unregistered Artists</h4>
        <hr>
        <div id="added_unregistered_artists">
            @php($count = 0)
            @if(empty(old('unregistered_artists')))
                @foreach($event->unregisteredArtists()->get() as $unregisteredArtist)
                    <div id="unregistered_artist_row_{{ $count }}" class="row col-auto pb-1">
                        <div class="input-group">
                            <input class="form-control col-auto" type="text"
                                   name="unregistered_artists[{{ $count }}][name]"
                                   id="unregistered_artists[{{ $count }}][name]" value="{{ $unregisteredArtist->name }}"
                                   readonly>
                            <input class="form-control col-auto" type="text"
                                   name="unregistered_artists[{{ $count }}][spotify]"
                                   id="unregistered_artists[{{ $count }}][spotify]"
                                   value="{{ $unregisteredArtist->spotify }}" readonly>
                            <input class="form-control col-auto" type="text"
                                   name="unregistered_artists[{{ $count }}][soundcloud]"
                                   id="unregistered_artists[{{ $count }}][soundcloud]"
                                   value="{{ $unregisteredArtist->soundcloud }}" readonly>
                            <input class="form-control col-auto" type="text"
                                   name="unregistered_artists[{{ $count }}][youtube]"
                                   id="unregistered_artists[{{ $count }}][youtube]"
                                   value="{{ $unregisteredArtist->youtube }}" readonly>
                            <input class="form-control col-auto" type="text"
                                   name="unregistered_artists[{{ $count }}][amazon_music]"
                                   id="unregistered_artists[{{ $count }}][amazon_music]"
                                   value="{{ $unregisteredArtist->amazon_music }}" readonly>
                            <input class="form-control col-auto" type="text"
                                   name="unregistered_artists[{{ $count }}][apple_music]"
                                   id="unregistered_artists[{{ $count }}][apple_music]"
                                   value="{{ $unregisteredArtist->apple_music }}" readonly>
                            <button class="btn btn-danger" type="button" id="delete_unregistered_{{ $count }}"
                                    onclick="deleteArtist(unregistered_artist_row_{{ $count }})">Delete
                            </button>
                        </div>
                    </div>
                    @php($count++)
                @endforeach
            @else
                @foreach(old('unregistered_artists') as $unregisteredArtist)
                    <div id="unregistered_artist_row_{{ $count }}" class="row col-auto pb-1">
                        <div class="input-group">
                            <input class="form-control col-auto" type="text"
                                   name="unregistered_artists[{{ $count }}][name]"
                                   id="unregistered_artists[{{ $count }}][name]"
                                   value="{{ $unregisteredArtist['name'] }}" readonly>
                            <input class="form-control col-auto" type="text"
                                   name="unregistered_artists[{{ $count }}][spotify]"
                                   id="unregistered_artists[{{ $count }}][spotify]"
                                   value="{{ $unregisteredArtist['spotify'] }}" readonly>
                            <input class="form-control col-auto" type="text"
                                   name="unregistered_artists[{{ $count }}][soundcloud]"
                                   id="unregistered_artists[{{ $count }}][soundcloud]"
                                   value="{{ $unregisteredArtist['soundcloud'] }}" readonly>
                            <input class="form-control col-auto" type="text"
                                   name="unregistered_artists[{{ $count }}][youtube]"
                                   id="unregistered_artists[{{ $count }}][youtube]"
                                   value="{{ $unregisteredArtist['youtube'] }}" readonly>
                            <input class="form-control col-auto" type="text"
                                   name="unregistered_artists[{{ $count }}][amazon_music]"
                                   id="unregistered_artists[{{ $count }}][amazon_music]"
                                   value="{{ $unregisteredArtist['amazon_music'] }}" readonly>
                            <input class="form-control col-auto" type="text"
                                   name="unregistered_artists[{{ $count }}][apple_music]"
                                   id="unregistered_artists[{{ $count }}][apple_music]"
                                   value="{{ $unregisteredArtist['apple_music'] }}" readonly>
                            <button class="btn btn-danger" type="button" id="delete_unregistered_{{ $count }}"
                                    onclick="deleteArtist(unregistered_artist_row_{{ $count }})">Delete
                            </button>
                        </div>
                    </div>
                    @php($count++)
                @endforeach
            @endif
        </div>
        <h4>Added Registered Artists</h4>
        <div id="added_registered_artists">
            <div class="col-auto row">
                <div class="col-12">Name & Tag</div>
                <hr>
                @php($count = 0)
                @if(empty(old('registered_artists')))
                    @foreach($event->artists()->get() as $artist)
                        <div id="registered_artist_row_{{ $count }}" class="row pb-1">
                            <div class="input-group">
                                <input class="form-control col-4" type="text"
                                       name="registered_artists[{{ $count }}][name]"
                                       id="registered_artists[{{ $count }}][name]" value="{{ $artist->name }}" readonly>
                                <input class="form-control col-4" type="text"
                                       name="registered_artists[{{ $count }}][tag]"
                                       id="registered_artists[{{ $count }}][tag]" value="{{ $artist->tag }}" readonly>
                                <button class="btn btn-danger" type="button" id="delete_registered_{{ $count }}"
                                        onclick="deleteArtist(registered_artist_row_{{ $count }})">Delete
                                </button>
                            </div>
                        </div>
                        @php($count++)
                    @endforeach
                @else
                    @foreach(old('registered_artists') as $artist)
                        <div id="registered_artist_row_{{ $count }}" class="row pb-1">
                            <div class="input-group">
                                <input class="form-control col-4" type="text" name="registered_artists[][name]"
                                       value="{{ $artist['name'] }}" readonly>
                                <input class="form-control col-4" type="text" name="registered_artists[][tag]"
                                       value="{{ $artist['tag'] }}" readonly>
                                <button class="btn btn-danger" type="button" id="delete_registered_{{ $count }}"
                                        onclick="deleteArtist(registered_artist_row_{{ $count }})">Delete
                                </button>
                            </div>
                        </div>
                        @php($count++)
                    @endforeach
                @endif
            </div>
        </div>
        <br>
        <hr>
        <br>
        <input class="btn btn-primary" type="submit" name="submit" id="submit" value="Submit">
    </form>
        <form class=" float-end" action="/events/{{ $event->id }}" method="POST">
            @csrf @method('DELETE')
            @if($event->cancelled)
                <input class="btn btn-success" type="submit" name="submit" id="submit" value="Re-publish Event">
            @else
                <input class="btn btn-danger" type="submit" name="submit" id="submit" value="Cancel Event">
            @endif
        </form>

</div>
<script>

    var unregisteredArtistCount = 10000;
    var registeredArtistCount = 10000;

    function addUnregisteredArtist() {
        if (document.getElementById("unregistered_artist").value === "") {
            return
        }
        var divRow = document.createElement("div");
        divRow.className = "col-auto row pb-1"
        divRow.id = "unregistered_artist_row_" + unregisteredArtistCount;

        var divInputGroup = document.createElement("div");
        divInputGroup.className = "input-group";

        var input = document.createElement("input");
        input.type = "text";
        input.value = document.getElementById("unregistered_artist").value;
        input.name = "unregistered_artists[" + unregisteredArtistCount + "][name]";
        input.id = "unregistered_artist_" + unregisteredArtistCount;
        input.className = "form-control col-auto" + unregisteredArtistCount;
        input.readOnly = true;

        var spotify = document.createElement("input");
        spotify.type = "text";
        spotify.value = document.getElementById("unregistered_artist_spotify").value;
        spotify.name = "unregistered_artists[" + unregisteredArtistCount + "][spotify]";
        spotify.id = "unregistered_artist_" + unregisteredArtistCount + "_spotify";
        spotify.className = "form-control col-auto" + unregisteredArtistCount;
        spotify.readOnly = true;

        var soundcloud = document.createElement("input");
        soundcloud.type = "text";
        soundcloud.value = document.getElementById("unregistered_artist_soundcloud").value;
        soundcloud.name = "unregistered_artists[" + unregisteredArtistCount + "][soundcloud]";
        soundcloud.id = "unregistered_artist_" + unregisteredArtistCount + "_soundcloud";
        soundcloud.className = "form-control col-auto" + unregisteredArtistCount;
        soundcloud.readOnly = true;

        var youtube = document.createElement("input");
        youtube.type = "text";
        youtube.value = document.getElementById("unregistered_artist_youtube").value;
        youtube.name = "unregistered_artists[" + unregisteredArtistCount + "][youtube]";
        youtube.id = "unregistered_artist_" + unregisteredArtistCount + "_youtube";
        youtube.className = "form-control col-auto" + unregisteredArtistCount;
        youtube.readOnly = true;

        var amazonMusic = document.createElement("input");
        amazonMusic.type = "text";
        amazonMusic.value = document.getElementById("unregistered_artist_amazon_music").value;
        amazonMusic.name = "unregistered_artists[" + unregisteredArtistCount + "][amazon_music]";
        amazonMusic.id = "unregistered_artist_" + unregisteredArtistCount + "_amazon_music";
        amazonMusic.className = "form-control col-auto" + unregisteredArtistCount;
        amazonMusic.readOnly = true;

        var appleMusic = document.createElement("input");
        appleMusic.type = "text";
        appleMusic.value = document.getElementById("unregistered_artist_apple_music").value;
        appleMusic.name = "unregistered_artists[" + unregisteredArtistCount + "][apple_music]";
        appleMusic.id = "unregistered_artist_" + unregisteredArtistCount + "_apple_music";
        appleMusic.className = "form-control col-auto" + unregisteredArtistCount;
        appleMusic.readOnly = true;

        var deleteButton = document.createElement("button");
        deleteButton.id = "delete_unregistered_" + unregisteredArtistCount;
        deleteButton.className = "btn btn-danger";
        deleteButton.innerText = "Delete";
        deleteButton.type = "button";
        deleteButton.setAttribute("onClick", "deleteArtist(unregistered_artist_row_" + unregisteredArtistCount + ")");

        var addedArtists = document.getElementById("added_unregistered_artists")
        addedArtists.appendChild(divRow);
        divRow.appendChild(divInputGroup)
        divInputGroup.appendChild(input);
        divInputGroup.appendChild(spotify);
        divInputGroup.appendChild(soundcloud);
        divInputGroup.appendChild(youtube);
        divInputGroup.appendChild(amazonMusic);
        divInputGroup.appendChild(appleMusic);
        divInputGroup.appendChild(deleteButton);

        unregisteredArtistCount++;
    }

    function addRegisteredArtist() {
        var divRow = document.createElement("div");
        divRow.className = "col-auto row pb-1"
        divRow.id = "registered_artist_row_" + registeredArtistCount;

        var divInputGroup = document.createElement("div");
        divInputGroup.className = "input-group";

        const artistFQDN = document.getElementById("registered_artist").value
        if (artistFQDN === "") {
            return
        }
        const tag = artistFQDN.substring(artistFQDN.length - 4);
        const name = artistFQDN.substring(0, artistFQDN.length - 5);
        console.log(name);

        var input = document.createElement("input");
        input.type = "text";
        input.value = name;
        input.name = "registered_artists[" + registeredArtistCount + "][name]";
        input.id = "registered_artists[" + registeredArtistCount + "]";
        input.className = "form-control col-4" + registeredArtistCount;
        input.readOnly = true;

        var inputTag = document.createElement("input");
        inputTag.type = "text";
        inputTag.value = tag;
        inputTag.name = "registered_artists[" + registeredArtistCount + "][tag]";
        inputTag.id = "registered_artist_tag_" + registeredArtistCount;
        inputTag.className = "form-control col-4" + registeredArtistCount;
        inputTag.readOnly = true;


        var deleteButton = document.createElement("button");
        deleteButton.id = "delete_unregistered_" + registeredArtistCount;
        deleteButton.className = "btn btn-danger";
        deleteButton.innerText = "Delete";
        deleteButton.type = "button";
        deleteButton.setAttribute("onClick", "deleteArtist(registered_artist_row_" + registeredArtistCount + ")");

        var addedArtists = document.getElementById("added_registered_artists")
        addedArtists.appendChild(divRow);
        divRow.appendChild(divInputGroup)
        divInputGroup.appendChild(input);
        divInputGroup.appendChild(inputTag);
        divInputGroup.appendChild(deleteButton);
        registeredArtistCount++;
    }

    function deleteArtist(id) {
        id.remove();
    }

    function fillOrganizer(organizers) {
        const element = document.getElementById("organizer_profile_tag");
        let venueFQDN = element.value;
        const tag = venueFQDN.substring(venueFQDN.length - 4);
        const organizerName = document.getElementById("organizer_name");
        organizers.forEach((e) => {
            if (e["tag"] === tag) {
                organizerName.value = e["name"];
            }
        })
    }

    function changeReadOnly(id) {
        if (!Array.isArray(id)) {
            const element = document.getElementById(id);
            element.readOnly = !element.readOnly;
            var isInput = element instanceof HTMLInputElement;
            if (isInput) {
                element.value = "";
            }
            return;
        }
        id.forEach((element) => {
            element = document.getElementById(element);
            element.readOnly = !element.readOnly;
            var isInput = element instanceof HTMLInputElement;
            if (isInput) {
                element.value = "";
            }
        });
    }

    function changeDisabled(id) {
        if (!Array.isArray(id)) {
            const element = document.getElementById(id);
            element.disabled = !element.disabled;
            var isInput = element instanceof HTMLInputElement;
            if (isInput) {
                element.value = "";
            }
            return;
        }
        id.forEach((element) => {
            element = document.getElementById(element);
            element.disabled = !element.disabled;
            var isInput = element instanceof HTMLInputElement;
            if (isInput) {
                element.value = "";
            }
        });
    }


    function fillVenue(venues) {
        const element = document.getElementById("venue");
        let venueFQDN = element.value;
        const tag = venueFQDN.substring(venueFQDN.length - 4);
        const venueName = document.getElementById("venue_name");
        const venueStreet = document.getElementById("venue_street");
        const venueNumber = document.getElementById("venue_number");
        const venueZip = document.getElementById("venue_zip");
        const venueCity = document.getElementById("venue_city");
        venues.forEach((e) => {
            if (e["tag"] === tag) {
                venueName.value = e["name"];
                venueStreet.value = e["street"];
                venueNumber.value = e["number"];
                venueZip.value = e["zip"];
                venueCity.value = e["city"];
            }
        })
    }
</script>
