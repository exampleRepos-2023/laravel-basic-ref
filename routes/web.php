<?php

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

// Post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware(MustBeLoggedIn::class);
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware(MustBeLoggedIn::class);
Route::get('/post/{post}', [PostController::class, 'showSinglePost']);
Route::delete('/post/{post}', [PostController::class, 'deletePost'])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, 'editPost'])->middleware('can:update,post');


// Profile related routes
Route::get('/profile/{user:username}', [UserController::class, 'showProfile']);
