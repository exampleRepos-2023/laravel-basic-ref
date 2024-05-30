<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function getPost()
    {
        $post = Post::where('id', request('post'))->firstOrFail();
        return view('single-post', [
            'post' => $post,
        ]);
    }

    public function storeNewPost(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body'  => 'required',
        ]);

        $incomingFields['title']   = strip_tags($incomingFields['title']);
        $incomingFields['body']    = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->user()->id;

        $newPost = Post::create($incomingFields);
        return redirect("/post/{$newPost->id}")->with('success', 'Post created successfully');

    }

    public function showCreateForm()
    {
        return view('create-post');
    }

}
