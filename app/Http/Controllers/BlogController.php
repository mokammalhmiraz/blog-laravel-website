<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Reaction;
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
        // $blogs = Blog::where('added_by', '=', Auth::id())->latest()->get();
        return view('blog.blogcategory');
    }

    function index(){
        $blogs = Blog::where('added_by', '=', Auth::id())->latest()->get();
        return view('blog.blogpost',  compact('blogs'));
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
        return back()->with('status', 'Blog Added Succecfully!');
    }

    function edit($blog_id){
        $blog = Blog::find($blog_id);
        return view('blog.blogpostedit',  compact('blog'));
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

        $blogs = Blog::where('added_by', '=', Auth::id())->latest()->get();
        // Return a specific view with the status message
        return view('blog.blogpost', compact('blogs'), ['blog' => $blog,'status' => 'Blog updated successfully!']);
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
        }
        return back();
    }

    function list(){
        $blogs = Blog::all();
        return view('blog.bloglist',  compact('blogs'));
    }

    function fullview($blog_id){
        $blog = Blog::find($blog_id);
        $comments = Comment::where('blog_id', '=', $blog_id)->latest()->get();
        $reaction = Reaction::where('blog_id', '=', $blog_id)->where('user_id', '=' , Auth::id())->first();
        return view('blog.blogview',  compact('blog','comments','reaction'));
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
        $reaction = Reaction::where('blog_id', '=', $blog_id)->where('user_id', '=' , Auth::id())->first();
        if($reaction->reaction == 'Like'){
            return back();
        }elseif($reaction->reaction == 'Dislike'){
            $blog = Blog::find($blog_id);
            $blog->dislikes -= 1;
            $blog->likes += 1;
            $blog->save();
            $reaction->reaction = "Like";
            $reaction->save();
            return back()->with('status', 'Blog Added Succecfully!');
        }
        else{
            $blog = Blog::find($blog_id);
            $blog->likes += 1;
            $blog->save();
            Reaction::insert([
                'user_id' => Auth::id(),
                'blog_id' => $blog_id,
                'reaction' => 'Like'
            ]);
            return back()->with('status', 'Blog Added Succecfully!');
        }
    }
    function dislike($blog_id){
        $reaction = Reaction::where('blog_id', '=', $blog_id)->where('user_id', '=' , Auth::id())->first();
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
