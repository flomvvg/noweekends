<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['create', 'store']);
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
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return to_route('users.show', ['user' => $user->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $this->authorize('view', [$user]);
        $organizers = $user->organizers()->get();
        $artists = $user->artists()->get();
        $venues = $user->venues()->get();
        return view('users.show', ['user' => $user, 'organizers' => $organizers, 'artists' => $artists, 'venues' => $venues]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', [$user]);
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', [$user]);
        $user->update($request->validated());

        return to_route('users.show', ['user' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', [$user]);
        $dateTime = Carbon::now();
        $userName = Hash::make($user->username);
        $userName = $userName . $dateTime->toString();
        $user->username = "Deleted User [" . Hash::make($userName) . "]";

        $dateTime = Carbon::now();
        $email = Hash::make($user->email);
        $email = $email . $dateTime->toString();
        $email = Hash::make($email);

        $user->email = $email;
        $user->save();

        return to_route('logout')->with('status', 'Your User has been deleted');
    }
}
