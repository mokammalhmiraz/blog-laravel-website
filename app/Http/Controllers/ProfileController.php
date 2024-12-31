<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Blog;
use App\Models\Activity;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
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
    function index(){
        $blogs = Blog::where('added_by','=',Auth::id())->latest()->get();
        $activities = Activity::where('added_by','=',Auth::id())->get();
        $data = Profile::where('user_id','=', Auth::id())->first();
        return view('profile.profile', compact('data','activities','blogs'));
    }
    function edit(){
        $user_info = Profile::where('user_id','=', Auth::id())->first();
        return view('profile.editprofile', compact('user_info'));
    }

    public function insert(Request $request){
        $request->validate([
            'name' => 'nullable|string|max:255',
            'profession' => 'nullable|string|max:255',
            'intro' => 'nullable|string', // No need to add word count validation here
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max image size
        ], [
            'image.max' => 'The profile image must not exceed 2MB in size.',
            'image.mimes' => 'The profile image must be a file of type: jpeg, png, jpg, gif.',
            'intro.max' => 'Intro must must be in between 50 words.',
            'name.max' => 'The name should not exceed 255 characters.',
            'profession.max' => 'The profession field should not exceed 255 characters.',
        ]);

        // Manually check word count for the intro field
        $introWordCount = str_word_count($request->intro);

        if ($introWordCount > 50) {
            // Return back with an error message if word count exceeds 50
            return back()->withErrors(['intro' => 'The intro should not exceed 50 words.']);
        }
        // Retrieve the user's profile
        $user_info = Profile::where('user_id', '=', Auth::id())->first();

        // Check if the name, profession, intro, and address are provided in the request
        if ($request->has('name')) {
            $user = User::find(Auth::id());
            $user->name = $request->name;
            $user_info->name = $request->name;
            $user->save();
        }

        if ($request->has('profession')) {
            $user_info->profession = $request->profession;
        }

        if ($request->has('intro')) {
            $user_info->intro = $request->intro;
        }

        if ($request->has('address')) {
            $user_info->address = $request->address;
        }

        // Check if an image is provided in the request
        if ($request->hasFile('image')) {
            // Validate the image dimensions (optional)
            $image = $request->file('image');
            $imageDimensions = getimagesize($image);
            $width = $imageDimensions[0];  // Width of the image
            $height = $imageDimensions[1]; // Height of the image

            // Check if the image dimensions meet the requirements (e.g., min width = 200px and height = 200px)
            if ($width > 200 || $height > 200) {
                return back()->withErrors(['image' => 'The image maximum 200x200 pixels.']);
            }

            // Delete the old image if it exists
            $oldImagePath = public_path('uploads/profile/' . $user_info->image);
            if (file_exists($oldImagePath) && !is_dir($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Save the new image
            $newImage = $request->file('image');
            $newImageName = $user_info->id . '.' . $newImage->getClientOriginalExtension();
            $newImagePath = public_path('uploads/profile');

            // Move the new image to the uploads folder
            $newImage->move($newImagePath, $newImageName);

            // Update the profile image in the database
            $user_info->image = $newImageName;
        }

        // Save all the updated data
        $user_info->save();

        return back()->with('status', 'Profile updated successfully!');
    }
    function activity(){
        $activities = Activity::where('added_by','=',Auth::id())->get();
        return view('profile.editactivity',compact('activities'));
    }
    function addactivity(Request $request){
        $request->activityname;
        Activity::insert([
            'added_by' => Auth::id(),
            'activity' => $request->activityname,
        ]);
        return back()->with('status', 'Activity Added Succecfully!');
    }
    function delete($activity_id){
        Activity::find($activity_id)->delete();
        return back()->with('status', 'Activity Deleted Succecfully!');
    }

    function view($profile_id){
        $blogs = Blog::where('added_by','=', $profile_id)->where('status','=','published')->latest()->get();
        $activities = Activity::where('added_by','=', $profile_id)->get();
        $data = Profile::where('user_id','=', $profile_id)->first();
        return view('profile.viewprofile', compact('data','activities','blogs'));
    }
    function authors(){
        // $blogs = Blog::where('added_by','=',Auth::id())->latest()->get();
        // $activities = Activity::where('added_by','=',Auth::id())->get();
        // $data = Profile::where('user_id','=', Auth::id())->first();
        $authors = User::where('role','=','Author')->where('status','=', 1)->get();
        return view('user.allauthor', compact('authors'));
    }

}
