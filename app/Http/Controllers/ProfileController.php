<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\MatchCurrentPassword;
use App\Models\User;

class ProfileController extends Controller
{
    //
    public function index(){
        return view('profile/show');
    }

    public function admin(){
        $user = User::find(auth()->id());
        return view('admin/profile',['user' => $user]);
    }

    public function user(){
        $user = User::find(auth()->id());
        return view('user/profile',['user' => $user]);
    }

    public function user_update(Request $request){
        $avatarPath = null;
        
        
        $id = $request->input('id');
        $email = $request->input('user_email');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        
        if($request->avatar !=null){
            $avatarName = uniqid().'.'.$request->avatar->extension();
            $avatarPath = 'assets/profile/'.$avatarName;
            $request->avatar->move(public_path('assets/profile'), $avatarName);
        }
        
        $user = User::find($id);
        $image = $user->avatar;
        if($image != null){
            File::delete(public_path($image));
        }

        $user->email = $email;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->avatar = $avatarPath;
        $user->save();
        return redirect('user/profile');
    }

    public function admin_update(Request $request){
        $avatarPath = null;
        
        
        $id = $request->input('id');
        $email = $request->input('user_email');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        
        if($request->avatar !=null){
            $avatarName = uniqid().'.'.$request->avatar->extension();
            $avatarPath = 'assets/profile/'.$avatarName;
            $request->avatar->move(public_path('assets/profile'), $avatarName);
        }
        
        $user = User::find($id);
        $image = $user->avatar;
        if($image != null){
            File::delete(public_path($image));
        }

        $user->email = $email;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->avatar = $avatarPath;
        $user->save();
        return redirect('admin/profile');
    }

    public function change_admin(){
        return view('admin/change');
    }

    public function admin_password(Request $request){
        $validation = Validator::make($request->all(), [
            'current_password' => ['required', new MatchCurrentPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        if ($validation->fails())
        {
            // The given data did not pass validation
            return redirect()->back()->withErrors($validation->errors());
        }

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        return redirect('admin/profile');
    }

    public function change_user(){
        return view('user/change');
    }

    public function user_password(Request $request){
        $validation = Validator::make($request->all(), [
            'current_password' => ['required', new MatchCurrentPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        if ($validation->fails())
        {
            // The given data did not pass validation
            return redirect()->back()->withErrors($validation->errors());
        }

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        return redirect('user/profile');
    }
    public function detail(){
        $owner_id = auth()->id();
        $user = User::find($owner_id);
        return response()->json(['user'=>$user]);
    }


}
