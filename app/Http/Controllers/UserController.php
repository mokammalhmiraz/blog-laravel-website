<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
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
    public function index()
    {
        $userlist = User::where('status', '=', '1')->latest()->get();
        return view('user.userlist', compact('userlist'));
    }
    public function requestlist()
    {
        $requestlist = User::all()->where('status', '=', '0');
        return view('user.requestlist', compact('requestlist'));
    }

    function update($user_id){
        $user = User::find($user_id);
        $user->status= 1;
        $user->save();
        return back();
    }
    function delete($user_id){
        $user = User::find($user_id);
        $blogs = Blog::where('added_by', '=', $user_id)->get();
        if($blogs){
            // Print each blog
            foreach ($blogs as $blog) {

                $reactions = Reaction::where('blog_id','=',$blog->id)->get();
                $comments = Comment::where('blog_id','=',$blog->id)->get();

                Blog::find($blog->id)->delete();
                if($reactions){
                    // Print each reaction by blog
                    foreach ($reactions as $reaction) {
                        Reaction::find($reaction->id)->delete();
                    }
                }
                if($comments){
                    // Print each comment by blog
                    foreach ($comments as $comment) {
                        Comment::find($comment->id)->delete();
                    }
                }

            }
            User::find($user_id)->delete();
        }
        else{
            User::find($user_id)->delete();
        }
        return back();
        return back();
    }
    function categorydelete($category_id){
        $category = Blogcategory::find($category_id);
        $blogs = Blog::where('category', '=', $category->name)->get();

        if($blogs){
            // Print each blog
            foreach ($blogs as $blog) {

                $reactions = Reaction::where('blog_id','=',$blog->id)->get();
                $comments = Comment::where('blog_id','=',$blog->id)->get();

                Blog::find($blog->id)->delete();
                if($reactions){
                    // Print each reaction by blog
                    foreach ($reactions as $reaction) {
                        Reaction::find($reaction->id)->delete();
                    }
                }
                if($comments){
                    // Print each comment by blog
                    foreach ($comments as $comment) {
                        Comment::find($comment->id)->delete();
                    }
                }

            }
            Blogcategory::find($category_id)->delete();
        }
        else{
            Blogcategory::find($category_id)->delete();
        }
        return back();
    }
}
