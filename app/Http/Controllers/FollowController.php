<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller {
    public function createFollow(User $user) {
        // you cannot follow yourself
        if ($user->id == auth()->user()->id) {
            return back()->with('error', 'You cannot follow yourself');
        }

        // check if you already follow this user
        $existCheck = Follow::where([
            ['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();

        if ($existCheck) {
            return back()->with('error', 'You already follow ' . $user->username);
        }

        $newFollow               = new Follow();
        $newFollow->user_id      = auth()->user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        return back()->with('success', 'You are now following ' . $user->username);
    }

    public function removeFollow(User $user) {
        Follow::where([
            ['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]
        ])->delete();

        return back()->with('success', 'You are no longer following ' . $user->username);
    }
}
