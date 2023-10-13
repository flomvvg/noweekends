<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterEventsRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Artist;
use App\Models\Event;
use App\Models\Genre;
use App\Models\Organizer;
use App\Models\UnregisteredArtist;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(FilterEventsRequest $request): View
    {
        if ($request->filled('artist')) {
            $tag = substr($request->artist, -4);
            $request->artist = Artist::where('tag', $tag)->first()->id;
        }

        $filteredEvents = Event::query()
            ->when(!$request->filled('end_date'), fn(Builder $q) => $q->where('end_date', '>', Carbon::now()))
            ->when($request->filled('type'), fn(Builder $q) => $q->where('type', $request->type))
            ->when($request->filled('end_date'), fn(Builder $q) => $q->where('end_date', '>=', $request->end_date))
            ->when($request->filled('weather_condition'), fn(Builder $q) => $q->where('weather_condition', $request->weather_condition))
            ->when($request->filled('city'), fn(Builder $q) => $q
                ->join('venues', fn(JoinClause $j) => $j->on('venues.id', '=', 'events.venue_id')
                ->where('venues.city', $request->city)
                ->orWhere('events.city', $request->city))->select('events.*'))
            ->when($request->filled('minimum_age'), fn(Builder $q) => $q->where('minimum_age', '>=', $request->minimum_age))
            ->when($request->filled('minimum_age_sm'), fn(Builder $q) => $q->where('minimum_age', '<=', $request->minimum_age_sm))
            ->when($request->filled('genre'), fn(Builder $q) => $q
                ->join('genres', fn(JoinClause $j) => $j->on('genres.id', '=', 'events.genre_id')
                    ->where('genres.name', $request->genre))->select('events.*'))
            ->when($request->filled('search'), fn(Builder $q) => $q->where('events.id', 'LIKE', '%' . $request->search . '%')
                ->orWhere('events.name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('events.description', 'LIKE', '%' . $request->search . '%')
                ->orWhere('events.type', 'LIKE', '%' . $request->search . '%')
                ->orWhere('events.weather_condition', 'LIKE', '%' . $request->search . '%')
                ->orWhere('events.start_date', 'LIKE', '%' . $request->search . '%')
                ->orWhere('events.start_time', 'LIKE', '%' . $request->search . '%')
                ->orWhere('events.end_date', 'LIKE', '%' . $request->search . '%')
                ->orWhere('events.end_time', 'LIKE', '%' . $request->search . '%')
                ->orWhere('events.minimum_age', 'LIKE', '%' . $request->search . '%')
                ->orWhere('events.venue_name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('events.street', 'LIKE', '%' . $request->search . '%')
                ->orWhere('events.city', 'LIKE', '%' . $request->search . '%'))
            ->when($request->filled('artist'), fn(Builder $q) => $q
                ->join('artist_event', 'events.id', '=', "artist_event.event_id")
                ->join('artists', 'artists.id', '=', 'artist_event.artist_id')
                ->where('artists.id', $request->artist))->select('events.*')
            ->orderBy('end_date', 'asc')->paginate(10);

        $genres = Genre::all();
        $artists = Artist::all();

        return view('events.index', [
            'events' => $filteredEvents,
            'genres' => $genres,
            'artists' => $artists,
            'filter' => $request->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userProfiles = Auth::user()->organizers()->get();
        $userProfiles = $userProfiles->concat(Auth::user()->venues()->get());
        $userProfiles = $userProfiles->concat(Auth::user()->artists()->get());

        if ($userProfiles->isEmpty()) {
            return to_route('profiles.create')->with('status', 'Your currently do not own any Profiles. To create an Event, you need a Profile.');
        }

        $genres = Genre::all();
        $artists = Artist::all();
        $venues = Venue::all();

        return view('events.create', [
            'genres' => $genres,
            'userProfiles' => $userProfiles,
            'artists' => $artists,
            'venues' => $venues,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();

        if (!empty($validated['presale_available'])) {
            $validated['presale_available'] = true;
        }

        if (!empty($validated['box_office_available'])) {
            $validated['box_office_available'] = true;
        }

        if (!empty($validated['oneway'])) {
            $validated['oneway'] = true;
        }

        $validated['venue_id'] = null;
        if (!empty($validated['venue_registered'])) {
            $validated['venue_registered'] = true;
            $venue = Venue::where('tag', $validated['venue'])->first();
            $validated['venue_id'] = $venue->id;
            unset($validated['venue']);
        } else {
            $validated['venue_registered'] = false;
        }

        $genre = Genre::where('name', $validated['genre'])->first();
        $validated['genre_id'] = $genre->id;
        unset($validated['genre']);

        $organizer = Organizer::where('tag', $validated['organizer_profile_tag'])->get();
        $organizer = $organizer->merge(Venue::where('tag', $validated['organizer_profile_tag'])->get());
        $organizer = $organizer->merge(Artist::where('tag', $validated['organizer_profile_tag'])->get());
        $validated['organizer_profile_type'] = strtolower(class_basename($organizer->first()));
        $validated['organizer_profile_id'] = $organizer->first()->id;

        $event = Event::create($validated);

        if (!empty($validated['unregistered_artists'])) {
            foreach ($validated['unregistered_artists'] as $unregistered_artist) {
                $unregistered_artist['event_id'] = $event->id;
                UnregisteredArtist::create($unregistered_artist);
            }
        }

        if (!empty($validated['registered_artists_tags'])) {
            foreach ($validated['registered_artists_tags'] as $tag) {
                $artist = Artist::where('tag', $tag)->first();
                $event->artists()->attach($artist);
            }
        }

        return to_route('events.show', ['event' => $event]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $organizer = $event->organizerProfile();

        $genre = $event->genre()->first();
        $venue = null;
        if ($event->venue_registered) {
            $venue = $event->venue()->first();
        }
        $artists = $event->artists()->get();
        $artists = $artists->sortBy(['name', 'asc']);
        $unregisteredArtists = $event->unregisteredArtists()->get();
        $unregisteredArtists = $unregisteredArtists->sortBy(['name', 'asc']);

        return view('events.show', [
            'event' => $event,
            'organizer' => $organizer,
            'genre' => $genre,
            'venue' => $venue,
            'artists' => $artists,
            'unregisteredArtists' => $unregisteredArtists
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event, Request $request)
    {
        $user = $request->user();
        $userProfiles = $user->organizers()->get();
        $userProfiles = $userProfiles->concat($user->venues()->get());
        $userProfiles = $userProfiles->concat($user->artists()->get());

        $organizer = $event->organizerProfile();


        $this->authorize('edit', $event);
        return view('events.edit', [
            'event' => $event,
            'genres' => Genre::all(),
            'userProfiles' => $userProfiles,
            'venues' => Venue::all(),
            'artists' => Artist::all(),
            'eventOrganizer' => $organizer,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $validated = $request->validated();

        $event->artists()->detach();
        $event->unregisteredArtists()->delete();

        if (!empty($validated['presale_available'])) {
            $validated['presale_available'] = true;
        }

        if (!empty($validated['box_office_available'])) {
            $validated['box_office_available'] = true;
        }

        if (!empty($validated['oneway'])) {
            $validated['oneway'] = true;
        }

        $validated['venue_id'] = null;
        if ($request->filled('venue_registered')) {
            $validated['venue_registered'] = true;
            $venue = Venue::where('tag', $validated['venue'])->first();
            $validated['venue_id'] = $venue->id;
            unset($validated['venue']);
        } else {
            $validated['venue_registered'] = false;
        }

        $genre = Genre::where('name', $validated['genre'])->first();
        $validated['genre_id'] = $genre->id;
        unset($validated['genre']);

        $organizer = Organizer::where('tag', $validated['organizer_profile_tag'])->get();
        $organizer = $organizer->merge(Venue::where('tag', $validated['organizer_profile_tag'])->get());
        $organizer = $organizer->merge(Artist::where('tag', $validated['organizer_profile_tag'])->get());
        $validated['organizer_profile_type'] = strtolower(class_basename($organizer->first()));
        $validated['organizer_profile_id'] = $organizer->first()->id;

        $event->update($validated);

        if (!empty($validated['unregistered_artists'])) {
            foreach ($validated['unregistered_artists'] as $unregistered_artist) {
                $unregistered_artist['event_id'] = $event->id;
                UnregisteredArtist::create($unregistered_artist);
            }
        }

        if (!empty($validated['registered_artists'])) {
            foreach ($validated['registered_artists'] as $artist) {
                $artist = Artist::where('tag', $artist['tag'])->first();
                $event->artists()->attach($artist);
            }
        }

        return to_route('events.show', ['event' => $event]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->cancelled = !$event->cancelled;
        $event->save();

        return to_route('events.show', $event);
    }
}
