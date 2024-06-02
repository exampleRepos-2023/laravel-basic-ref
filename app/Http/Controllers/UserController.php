<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class UserController extends Controller {

    public function storeAvatar(Request $request) {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth()->user();

        // Generate a unique filename for the avatar
        $filename = $user->id . '-' . uniqid() . '.jpg';

        // Read the avatar file and resize it to 256x256
        $imgData = ImageManager::imagick()
            ->read($request->file('avatar'))
            ->contain(256, 256)->toJpg();

        // Store the avatar image in the public/avatars directory
        Storage::put('public/avatars/' . $filename, $imgData);

        // Get the old avatar filename
        $oldAvatar = $user->avatar;

        // Update the user's avatar with the new filename
        $user->update(['avatar' => $filename]);

        // Delete the old avatar image if it exists
        if ($oldAvatar != "/fallback-avatar.jpg") {
            Storage::delete(str_replace('/storage/', '/public/', $oldAvatar));
        }

        return redirect('/profile/' . $user->username)->with('success', 'Your avatar has been updated');
    }

    public function showAvatarForm() {
        return view('avatar-form');
    }

    public function showProfile(User $user) {
        $currentlyFollowing = 0;

        if (auth()->check()) {
            $currentlyFollowing = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();
        }

        return view('profile-posts', [
            'currentlyFollowing' => $currentlyFollowing,
            'username'           => $user->username,
            'avatar'             => $user->avatar,
            'posts'              => $user->posts()->get(),
            'postCount'          => $user->posts()->count()
        ]);
    }

    public function logout() {
        auth()->logout();
        return redirect('/')->with('success', 'You are now logged out');
    }

    public function showCorrectHomepage() {
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }

    public function login(Request $request) {
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

    public function register() {
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
