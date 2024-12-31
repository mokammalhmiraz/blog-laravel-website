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
        $blogcount = Blog::where('status', 'published')->count();// Order by 'views' in descending order
        $allblogs = Blog::where('status', 'published')->orderBy('views', 'desc')->get();// Order by 'views' in descending order
        $blogs = Blog::where('status', 'published')->latest()->take(2)->get();
        return view('home', compact('blogs','allblogs','blogcount'));
    }
}
