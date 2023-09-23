<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrganizerRequest;
use App\Models\Organizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
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

        return to_route('organizers.show', ['organizer' => $organizer]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
