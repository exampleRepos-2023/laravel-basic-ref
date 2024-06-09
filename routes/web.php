<?php

use App\Events\ChatMessage;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\MustBeLoggedIn;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/admins-only', function () {
    if (Gate::allows('admin')) {
        return 'You are an admin!';
    }
    return 'You need to be an admin to see this';
});

// User related routes
Route::get('/', [UserController::class, 'showCorrectHomepage'])->name('login');
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware(MustBeLoggedIn::class);
Route::get('/manage-avatar', [UserController::class, 'showAvatarForm'])->middleware(MustBeLoggedIn::class);
Route::post('/manage-avatar', [UserController::class, 'storeAvatar'])->middleware(MustBeLoggedIn::class);

// Follow related routes
Route::post('/create-follow/{user:username}', [FollowController::class, 'createFollow'])->middleware(MustBeLoggedIn::class);
Route::post('/remove-follow/{user:username}', [FollowController::class, 'removeFollow'])->middleware(MustBeLoggedIn::class);

// Post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware(MustBeLoggedIn::class);
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware(MustBeLoggedIn::class);
Route::get('/post/{post}', [PostController::class, 'showSinglePost']);
Route::delete('/post/{post}', [PostController::class, 'deletePost'])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, 'editPost'])->middleware('can:update,post');
Route::get('/search/{term}', [PostController::class, 'searchPosts']);


// Profile related routes
Route::get('/profile/{user:username}', [UserController::class, 'profile']);
Route::get('/profile/{user:username}/followers', [UserController::class, 'profileFollowers']);
Route::get('/profile/{user:username}/following', [UserController::class, 'profileFollowings']);


// Chat Routes
Route::post('/send-chat-message', function (Request $request) {
    $formFields = $request->validate([
        'textvalue' => 'required'
    ]);

    if (!trim($formFields['textvalue'])) {
        return response(['message' => 'Message cannot be empty.'], 400);
    }

    broadcast(new ChatMessage([
        'username'  => auth()->user()->username,
        'textvalue' => strip_tags($formFields['textvalue']),
        'avatar'    => auth()->user()->avatar
    ]));

    return response(['message' => 'Message sent.'], 200);

})->middleware(MustBeLoggedIn::class);
