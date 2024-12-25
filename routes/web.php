<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index']);

Route::get('/requestlist', [UserController::class, 'requestlist']);
Route::get('/user.update.{user_id}', [UserController::class, 'update']);

Route::get('/userlist', [UserController::class, 'userlist']);
Route::get("user.delete.{user_id}", [UserController::class, 'delete']);
