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
    public function userlist()
    {
        $userlist = User::all()->where('status', '=', '1');
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
        User::find($user_id)->delete();
        return back();
    }
}
