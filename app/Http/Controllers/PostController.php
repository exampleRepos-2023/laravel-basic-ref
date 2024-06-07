<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller {

    public function searchPosts($term) {
        $posts = Post::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
    }

    public function editPost(Request $request, Post $post) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body'  => 'required',
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body']  = strip_tags($incomingFields['body']);

        $post->update($incomingFields);
        return redirect("/post/{$post->id}")->with('success', 'Post created successfully');
    }

    public function showEditForm(Post $post) {
        return view('edit-post', [
            'post' => $post
        ]);
    }

    public function deletePost(Post $post) {
        $post->delete();
        return redirect('/profile/' . auth()->user()->username)
            ->with('success', 'Post deleted successfully');
    }

    public function showSinglePost(Post $post) {
        $post['body'] = strip_tags(
            Str::markdown($post->body), '<p><a><ul><li><strong><em><br>'
        );

        return view('single-post', [
            'post' => $post,
        ]);
    }

    public function storeNewPost(Request $request) {
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

    public function showCreateForm() {
        return view('create-post');
    }

}
