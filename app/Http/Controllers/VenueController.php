<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVenueRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Http\Requests\UpdateVenueRequest;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profiles.venues.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVenueRequest $request)
    {
        $venue = Venue::create($request->validated());
        $venue->users()->attach(Auth::user());

        return to_route('venues.show', ['venue' => $venue]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Venue $venue)
    {
        $users = $venue->users()->get();
        return view('profiles.venues.show', ['venue' => $venue, 'users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venue $venue)
    {
        $this->authorize('edit', $venue);

        return view('profiles.venues.edit', ['venue'=>$venue]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVenueRequest $request, Venue $venue)
    {
        $this->authorize('edit', $venue);
        $venue->update($request->validated());
        $users = $venue->users()->get();

        return view('profiles.venues.show', ['venue' => $venue, 'users' => $users]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue)
    {
        //
    }
}
