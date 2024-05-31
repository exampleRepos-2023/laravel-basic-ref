<?php

use App\Http\Controllers\PostController;
use App\Http\Middleware\MustBeLoggedIn;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// User related routes
Route::get('/', [UserController::class, 'showCorrectHomepage'])->name('login');
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware(MustBeLoggedIn::class);

// Post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware(MustBeLoggedIn::class);
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware(MustBeLoggedIn::class);
Route::get('/post/{post}', [PostController::class, 'showSinglePost']);
