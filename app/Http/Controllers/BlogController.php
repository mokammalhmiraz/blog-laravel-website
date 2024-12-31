<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Reaction;
use App\Models\Blogcategory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BlogController extends Controller
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
    function category(){
        $categories = Blogcategory::all();
        return view('blog.blogcategory', compact('categories'));
    }
    function categoryinsert(Request $request){
        Blogcategory::insert([
            'name' => $request->category,
            'added_by' => Auth::id()
        ]);
        return back()->with('status', 'Blog Added Succecfully!');
    }
    function categorydelete($category_id){
        Blogcategory::find($category_id)->delete();
        return back();
    }

    function index(){
        $blogcategories = Blogcategory::all();
        $blogs = Blog::where('added_by', '=', Auth::id())->latest()->get();
        return view('blog.blogpost',  compact('blogs','blogcategories'));
    }

    function insert(Request $blog){
        $blog->validate([
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
            'status' => 'required',
            'thumbnail' => 'required',
        ], [
            // 'category_name.required' => 'CUSTOM MESSAGE',
            // 'category_name.unique' => 'CUSTOM MESSAGE'
        ]);

        $blog_id = Blog::insertGetID([
            'title' => $blog->title,
            'content' => $blog->content,
            'category' => $blog->category,
            'status' => $blog->status,
            'added_by' => Auth::id(),
            'created_at' => Carbon::now()
        ]);
        $thumbnail_img = $blog->file('thumbnail');
        $thumbnail_img_name = $blog_id . "." . $thumbnail_img->getClientOriginalExtension();
        $path = public_path('/uploads/thumbnail/' . $thumbnail_img_name);

        $manager = new ImageManager(new Driver());
        $image = $manager->read($thumbnail_img);
        $image->toJpeg(100)->save($path);

        Blog::find($blog_id)->update([
            'thumbnail' => $thumbnail_img_name
        ]);
        Blogview::insert([
            'blog_id' => $blog_id,
            'views' => 0,
        ]);
        return back()->with('status', 'Blog Added Succecfully!');
    }

    function edit($blog_id){
        $blog = Blog::find($blog_id);
        $blogcategories = Blogcategory::all();
        return view('blog.blogpostedit',  compact('blog','blogcategories'));
    }

    public function update(Request $request){
        $blog = Blog::find($request->id);

        // Update only the attributes that are present in the request
        if ($request->has('title')) {
            $blog->title = $request->title;
        }

        if ($request->has('content')) {
            $blog->content = $request->content;
        }

        if ($request->has('category')) {
            $blog->category = $request->category;
        }

        if ($request->has('status')) {
            $blog->status = $request->status;
        }

        // Handle thumbnail image upload if a new image is provided
        if ($request->hasFile('thumbnail')) {
            // Delete the old image if it exists
            $oldThumbnail = public_path('uploads/thumbnail/' . $blog->thumbnail);
            if (file_exists($oldThumbnail)) {
                unlink($oldThumbnail);
            }

            // Save the new thumbnail
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = $blog->id . '.' . $thumbnail->getClientOriginalExtension();
            $path = public_path('uploads/thumbnail');
            $thumbnail->move($path, $thumbnailName);

            // Update the thumbnail name in the database
            $blog->thumbnail = $thumbnailName;
        }

        // Save the updated blog data
        $blog->save();

        $blogcategories = Blogcategory::all();
        $blogs = Blog::where('added_by', '=', Auth::id())->latest()->get();
        // Return a specific view with the status message
        return view('blog.blogpost', compact('blogs','blogcategories'), ['blog' => $blog,'status' => 'Blog updated successfully!']);
    }

    function publish($blog_id){
        $blog = Blog::find($blog_id);
        $blog->status = "published";
        $blog->save();
        return back();
    }

    function draft($blog_id){
        $blog = Blog::find($blog_id);
        $blog->status = "draft";
        $blog->save();
        return back();
    }

    function delete($blog_id){
        $blog = Blog::find($blog_id);
        if ($blog){
            $thumbnailPath = public_path('uploads/thumbnail/' . $blog->thumbnail);
            if(file_exists($thumbnailPath)){
                unlink($thumbnailPath);
            }
            $blog->delete();
            Blogview::where('blog_id','=',$blog_id)->delete();
            Reaction::where('blog_id','=',$blog_id)->delete();
            Comment::where('blog_id','=',$blog_id)->delete();
        }
        return back();
    }

    function list(Request $request){
        // Access the query parameter correctly
        $query = $request->query('query'); // Retrieve the 'query' parameter

        if ($query) {
            // If a query parameter exists, filter blogs based on the title
            $blogs = Blog::where('title', 'like', '%' . $query . '%')->latest()->get();
            // Return the view with the blogs
            return view('blog.bloglist', compact('blogs'));
        } else {
            // Otherwise, retrieve all published blogs
            $blogs = Blog::where('status', '=', 'published')->latest()->get();
            // Return the view with the blogs
            return view('blog.bloglist', compact('blogs'));
        }


    }

    function fullview($blog_id){
        $blog = Blog::find($blog_id);
        $comments = Comment::where('blog_id', '=', $blog_id)->latest()->get();
        $reaction = Reaction::where('blog_id', '=', $blog_id)->where('user_id', '=' , Auth::id())->first();
        if (is_null($reaction)){
            $reaction = 0;
            return view('blog.blogview',  compact('blog','comments','reaction'));
        }else{
            return view('blog.blogview',  compact('blog','comments','reaction'));
        }

    }

    function comment(Request $request){
        print_r($request->content);
        $request->validate([
            'content' => 'required',
        ]);
        Comment::insert([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'blog_id' => $request->blog_id,
            'created_at' => Carbon::now()
        ]);
        return back()->with('status', 'Blog Added Succecfully!');
    }
    function like($blog_id){
        // Retrieve the reaction for the given blog and user
        $reaction = Reaction::where('blog_id', '=', $blog_id)->where('user_id', '=', Auth::id())->first();

        // Check if the user has already reacted
        if ($reaction) {
            // If reaction is "Like", do nothing and return
            if ($reaction->reaction == 'Like') {
                return back();
            }
            // If reaction is "Dislike", change it to "Like"
            elseif ($reaction->reaction == 'Dislike') {
                $blog = Blog::find($blog_id);
                $blog->dislikes -= 1;  // Decrement dislikes
                $blog->likes += 1;     // Increment likes
                $blog->save();

                $reaction->reaction = "Like"; // Update reaction to "Like"
                $reaction->save();
                return back()->with('status', 'Blog Liked Successfully!');
            }
        } else {
            // If no reaction exists, create a new "Like"
            $blog = Blog::find($blog_id);
            $blog->likes += 1;  // Increment likes
            $blog->save();

            // Insert new reaction
            Reaction::insert([
                'user_id' => Auth::id(),
                'blog_id' => $blog_id,
                'reaction' => 'Like' // Set the reaction as "Like"
            ]);
            return back()->with('status', 'Blog Liked Successfully!');
        }
    }
    function dislike($blog_id){
        $reaction = Reaction::where('blog_id', '=', $blog_id)->where('user_id', '=' , Auth::id())->first();
        if ($reaction) {
            if($reaction->reaction == 'Like'){
                $blog = Blog::find($blog_id);
                $blog->dislikes += 1;
                $blog->likes -= 1;
                $blog->save();
                $reaction->reaction = "Dislike";
                $reaction->save();
                return back()->with('status', 'Blog Added Succecfully!');
            }elseif($reaction->reaction == 'Dislike'){
                return back();
            }
        }
        else{
            $blog = Blog::find($blog_id);
            $blog->dislikes += 1;
            $blog->save();
            Reaction::insert([
                'user_id' => Auth::id(),
                'blog_id' => $blog_id,
                'reaction' => 'Dislike'
            ]);
            return back()->with('status', 'Blog Added Succecfully!');
        }
    }
}
