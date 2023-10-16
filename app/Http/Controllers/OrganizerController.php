<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrganizerRequest;
use App\Http\Requests\UpdateOrganizerRequest;
use App\Models\Organizer;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class OrganizerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
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
        return view('profiles.organizers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizerRequest $request): RedirectResponse
    {
        $organizer = Organizer::create($request->validated());
        $organizer->users()->attach(Auth::user());

        return to_route('organizers.show', ['organizer' => $organizer]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organizer $organizer)
    {
        $upcomingEvents = $organizer->getUpcomingEvents();
        $pastEvents = $organizer->getPastEvents();

        $users = $organizer->users()->get();
        return view('profiles.organizers.show', [
            'organizer' => $organizer,
            'users' => $users,
            'pastEvents' => $pastEvents,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organizer $organizer): View
    {
        $this->authorize('edit', $organizer);

        return view('profiles.organizers.edit', ['organizer' => $organizer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizerRequest $request, Organizer $organizer): RedirectResponse
    {
        $this->authorize('edit', $organizer);
        $organizer->update($request->validated());

        return to_route('organizers.show', ['organizer' => $organizer])->with('status', 'Your user has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organizer $organizer): RedirectResponse
    {
        $this->authorize('delete', $organizer);
        $organizer->name = "[Deleted Organizer]";
        $organizer->tag = "";
        $organizer->description = null;
        $organizer->website = null;
        $organizer->archived = true;
        $organizer->users()->detach(Auth::id());
        $organizer->save();

        return to_route('users.show', Auth::user())->with('status', 'Your organizer profile has been deleted');
    }
}
