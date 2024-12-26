<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Blog;
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
    function index()
    {
        $blogs = Blog::where('added_by', '=', Auth::id())->latest()->get();
        return view('blog.blogpost',  compact('blogs'));
    }

    function insert(Request $blog)
    {
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
}
