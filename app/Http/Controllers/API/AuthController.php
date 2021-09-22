<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Balance;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $validatedData = Validator::make($request->all(),[
            'first_name' => 'required|max:55',
            'last_name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required',
            'device_token' =>'required'
        ]);
        
        if ($validatedData->fails())
        {
            // The given data did not pass validation
            return response()->json([ 'message' => $validatedData->errors()]);
        }
        
        $user = User::create([
            'first_name' =>$request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'type' => 'user',
            'device_token' => $request->device_token,
            'password' => Hash::make($request->password)
        ]);

        
        $user->assignRole('user');


        
        $accessToken = $user->createToken('authToken')->accessToken;
        return response()->json([ 'user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request){
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
          
        if (!auth()->attempt($loginData)) {
            return response()->json(['message' => 'Invalid Credentials']);
        }
        
        if($request->device_token == null){
            return response()->json(['message' => 'Invalid Credentials']);
        }
        auth()->user()->update(['device_token'=>$request->device_token]);
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function forget_password(Request $request){
        $credentials = $request->validate(['email' => 'required|email']);
        try{
            $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject($this->getEmailSubject());
            });
    
            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return response()->json(["status" => 200, "message" => trans($response)]);
                case Password::INVALID_USER:
                    return response()->json(["status" => 400, "message" => trans($response)]);
            }
        }catch (\Swift_TransportException $ex) {
            return response()->json(["status" => 400, "message" => $ex->getMessage()]);
        } catch (Exception $ex) {
            response()->json(["status" => 400, "message" => $ex->getMessage()]);
        }

    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }



    public function user(Request $request) {
        return response()->json($request->user());
    }
}
