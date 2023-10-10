<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Artist;
use App\Models\Event;
use App\Models\Genre;
use App\Models\Organizer;
use App\Models\UnregisteredArtist;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $organizerProfileType = new("App\\Models\\" . ucfirst($event->organizer_profile_type));
        $organizer = $organizerProfileType::find($event->organizer_profile_id)->first();

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

        $organizerProfileType = new("App\\Models\\" . ucfirst($event->organizer_profile_type));
        $eventOrganizer = $organizerProfileType::find($event->organizer_profile_id);


        $this->authorize('edit', $event);
        return view('events.edit', [
            'event' => $event,
            'genres' => Genre::all(),
            'userProfiles' => $userProfiles,
            'venues' => Venue::all(),
            'artists' => Artist::all(),
            'eventOrganizer' => $eventOrganizer,
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
        //
    }
}
