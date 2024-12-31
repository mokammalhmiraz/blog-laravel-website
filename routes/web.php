<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index']);

Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/editprofile', [ProfileController::class, 'edit']);
Route::post('/profile.insert', [ProfileController::class, 'insert']);
Route::get('/editactivity', [ProfileController::class, 'activity']);
Route::post('/activity.insert', [ProfileController::class, 'addactivity']);
Route::get('/activity.delete.{activity_id}', [ProfileController::class, 'delete']);
Route::get('/blog.profile_visit.{profile_id}', [ProfileController::class, 'view']); // Blog List
Route::get('/allauthor', [ProfileController::class, 'authors']); // Blog List
Route::get('/profile_visit.{profile_id}', [ProfileController::class, 'view']); // Blog List

Route::get('/requestlist', [UserController::class, 'requestlist']); // User Request List
Route::get('/user.update.{user_id}', [UserController::class, 'update']); // User Request Approval

Route::get('/userlist', [UserController::class, 'index']); // All User List
Route::get("user.delete.{user_id}", [UserController::class, 'delete']); // user Delete or Remove

Route::get('/blogcategory', [BlogController::class, 'category']); // Blog Post and Submission Form
Route::post('/blogcategory.insert', [BlogController::class, 'categoryinsert']); // Blog Post and Submission Form
Route::get('/category.delete.{category_id}', [BlogController::class, 'categorydelete']); // Blog Post and Submission Form
Route::get('/blogpost', [BlogController::class, 'index']); // Blog Post and Submission Form
Route::post('/blogpost.comment', [BlogController::class, 'comment']); // Blog Comment Form
Route::post('/blogpost.insert', [BlogController::class, 'insert']); // Blog Posting
Route::post('/blogpost.edit', [BlogController::class, 'update']); // Blog Posting
Route::get('/blogpost.publish.{blog_id}', [BlogController::class, 'publish']); // Blog Publishing
Route::get('/blogpost.draft.{blog_id}', [BlogController::class, 'draft']); // Blog Drafting
Route::get('/blogpost.edit.{blog_id}', [BlogController::class, 'edit']); // Blog Edit
Route::get('/blogpost.like.{blog_id}', [BlogController::class, 'like']); // Blog Like
Route::get('/blogpost.dislike.{blog_id}', [BlogController::class, 'dislike']); // Blog Like
Route::get('/blogpost.delete.{blog_id}', [BlogController::class, 'delete']); // Blog Deleting

Route::get('/bloglist', [BlogController::class, 'list']); // Blog List
Route::get('/bloglist.view.{blog_id}', [BlogController::class, 'fullview']); // Blog List

