<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Storage;
use App\admin_profile;
class AdminController extends Controller
{
    //
    public function index(){
    	$user=Auth::user();
    	//$admin_profile=DB::table('admin_profiles')->where('user_id','$user->id')->first();
    	return view('admin.home')->with('user',$user);
    	//->with('admin_profile',$admin_profile);
    }

    public function profile(){
    	$user=Auth::user();
    	//$admin_profile=DB::table('admin_profiles')->where('user_id',$user->id)->first();
    	return view('admin.profile')->with('user',$user); //->with('admin_profile',$admin_profile);
    	//return view('admin.profile',compact('user',$user));
    }

    // This is to update the avatar in user profile
    public function update_avatar(Request $request){
    	$request->validate(['avatar'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
    	$user=Auth::user();
    	$avatarName = $user->id.'_avatar.'.request()->avatar->getClientOriginalExtension();
    	// delete all avatar files of this user and then upload new profile pic
        Storage::delete('public/storage/avatars/'.$avatarName);
    	$request->avatar->storeAs('avatars',$avatarName);
    	$user->avatar = $avatarName;
    	$user->save(); // insert query will be fired
    	
    	return back()->with('success','You have successfully uploaded image.');
    }


    public function update_profile(Request $request){
    	$user=Auth::user();
    	$row = new User();
    	$row->id=$user->id;
    	$user->name=$request->get('name');
    	$user->email=$request->get('email');

//    	$validatedData = $request->validate([
//            'name' => 'required',
//            'email' => 'required|email|unique:users,email',
//        ]);

    	$user->save();
        $request->session()->flash('alert-success', 'Profile Updated Successfully!');
    	return back();

    }

    public function store(Request $request)
    {


        // The email is valid...
    }

}
