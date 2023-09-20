<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function authenticate(LoginRequest $request): RedirectResponse
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return to_route('users.show', ['user' => Auth::user()]);
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records'
        ]);
    }

    public function login(): View
    {
        return view('users.login');
    }

    public function logout(Request $request): View
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('users.logout');
    }
}
