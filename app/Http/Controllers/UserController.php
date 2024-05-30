<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'You are now logged out');
    }

    public function showCorrectHomepage()
    {
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }

    public function login(Request $request)
    {
        $incamingFields = request()->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required',
        ]);

        if (
            auth()->attempt([
                'username' => $incamingFields['loginusername'],
                'password' => $incamingFields['loginpassword'],
            ])
        ) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'You are now logged in');
        } else {
            return redirect('/')->with('failure', 'Login failed');
        }
    }

    public function register()
    {
        $incamingFields = request()->validate([
            'username' => 'required|min:3|max:20|alpha_dash|unique:users,username',
            'email'    => 'required|email',
            'password' => 'required|min:5|max:20',
        ]);

        $incamingFields['password'] = bcrypt($incamingFields['password']);

        $user = User::create($incamingFields);
        auth()->login($user);
        return redirect('/')->with('success', 'Your account has been created');
    }
}
