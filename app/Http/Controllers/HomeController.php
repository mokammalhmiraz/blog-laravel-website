<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $allblogs = Blog::where('status', 'published')->get();
        $blogs = Blog::where('status', 'published')->latest()->take(2)->get();
        return view('home', compact('blogs','allblogs'));
    }
}
